var Chat = require('twilio-chat');
var Video = require('twilio-video');
var {createLocalTracks, createLocalVideoTrack, isSupported} = require('twilio-video');

const MAX_FILE_SIZE = 157286400;
const NETWORK_QUALITY = ['Reconnecting..', 'Very Bad', 'Bad', 'Average', 'Good', 'Very Good']

var token;
var identity;
var userId;
var classId;
var activeRoom;
var screenTrack;
var videoElement;
var chatClient;
var chatChannel;
var initCounter = false;
var counterTimer = null;
var audioEnabled = true;
var videoEnabled = true;
var shareScreenContainer = document.getElementById('user-screens');
var statusContainer = document.getElementById('video-call-info');
var controlButtonsContainer = document.getElementById('control-buttons');

var $messageContainer = $('div#message-container');
var chatConnectStatus = document.getElementById('chat-connect-status');
var chatMessageInput = document.getElementById('chat-message-input');
var typingContainer = document.getElementById('typing-container');
var sendMessageButton = document.getElementById('button-send-message');
var attachmentInput = document.getElementById('file-input');
var sendingFileId = null;

const $modals = $('#modals');
const $selectMicModal = $('#select-mic', $modals);
const $selectCameraModal = $('#select-camera', $modals);
const $showErrorModal = $('#show-error', $modals);

const containerHeight = $('div#participants').height()
const containerWidth = $('div#participants').width()

const localTracks = {
    audio: null,
    video: null
};

const isMobile = (() => {
    if (typeof navigator === 'undefined' || typeof navigator.userAgent !== 'string') {
        return false;
    }
    return /Mobile/.test(navigator.userAgent);
})();

let deviceIds = {
    audio: null,
    //isMobile ? null : localStorage.getItem('audioDeviceId'),
    video: null
    //isMobile ? null : localStorage.getItem('videoDeviceId')
};

const AudioContext = window.AudioContext || window.webkitAudioContext;
const audioContext = AudioContext ? new AudioContext() : null;

console.log('is Mobile', isMobile)
console.log('Device IDS', deviceIds)

const connectOptions = {
    bandwidthProfile: {
        video: {
            dominantSpeakerPriority: 'high',
            mode: 'collaboration',
            renderDimensions: {
                high: {height: 720, width: 1280},
                standard: {height: 90, width: 160}
            }
        }
    },
    
    dominantSpeaker: true,
    
    // Comment this line to disable verbose logging.
    //logLevel: 'debug',
    
    // Comment this line if you are playing music.
    maxAudioBitrate: 16000,
    
    preferredVideoCodecs: [{codec: 'VP8', simulcast: true}],
    
    // Capture 720p video @ 24 fps.
    video: {height: 720, frameRate: 24, width: 1280}
};

function rootMeanSquare(samples) {
    const sumSq = samples.reduce((sumSq, sample) => sumSq + sample * sample, 0);
    return Math.sqrt(sumSq / samples.length);
}

if (audioContext) {
    function micLevel(stream, maxLevel, onLevel) {
        audioContext.resume().then(() => {
            const analyser = audioContext.createAnalyser();
            analyser.fftSize = 1024;
            analyser.smoothingTimeConstant = 0.5;
            
            const source = audioContext.createMediaStreamSource(stream);
            source.connect(analyser);
            const samples = new Uint8Array(analyser.frequencyBinCount);
            
            const track = stream.getTracks()[0];
            let level = null;
            
            requestAnimationFrame(function checkLevel() {
                analyser.getByteFrequencyData(samples);
                const rms = rootMeanSquare(samples);
                const log2Rms = rms && Math.log2(rms);
                const newLevel = Math.ceil(maxLevel * log2Rms / 8);
                
                if (level !== newLevel) {
                    level = newLevel;
                    onLevel(level);
                }
                
                requestAnimationFrame(track.readyState === 'ended'
                    ? () => onLevel(0)
                    : checkLevel);
            });
        });
    }
}

// For mobile browsers, limit the maximum incoming video bitrate to 2.5 Mbps.
if (isMobile) {
    connectOptions.bandwidthProfile.video.maxSubscriptionBitrate = 2500000
    connectOptions.audio = true
    //connectOptions.video = {height: 480, frameRate: 24, width: 640}
    //connectOptions.networkQuality = {local: 1, remote: 1}
}

const USER_FRIENDLY_ERRORS = {
    NotAllowedError: () => {
        return '<b>Causes: </b><br>1. The user has denied permission for your app to access the input device either by ' +
            'dismissing the permission dialog or clicking on the "deny" button.<br> 2. The user has denied permission for ' +
            'your app to access the input device in the browser settings.<br>'
            + '<br><b>Solutions: </b><br> 1. The user should reload your app and grant permission to access the input device.' +
            '<br> 2. The user should allow access to the input device in the browser settings and then reload your app.';
    },
    NotFoundError: () => {
        return '<b>Cause: </b><br>1. The user has disabled the input device for the browser in the system settings.' +
            '<br>2. The user\'s machine does not have such input device connected to it.<br>'
            + '<br><b>Solution</b><br>1. The user should enable the input device for the browser in the system settings' +
            '<br>2. The user should have atleast one input device connected.';
    },
    NotReadableError: () => {
        return '<b>Cause: </b><br>The browser could not start media capture with the input device even after the user gave' +
            ' permission, probably because another app or tab has reserved the input device.<br>'
            + '<br><b>Solution: </b><br>The user should close all other apps and tabs that have reserved the input device' +
            ' and reload your app, or worst case, restart the browser.';
    },
    OverconstrainedError: error => {
        return error.constraint === 'deviceId'
            ? '<b>Cause: </b><br>Your saved microphone or camera is no longer available.<br><br><b>Solution: </b>' +
            '<br>Please make sure the input device is connected to the machine.'
            : '<b>Cause: </b><br>Could not satisfy the requested media constraints. One of the reasons '
            + 'could be that your saved microphone or camera is no longer available.<br><br><b>Solution: </b><' +
            'br>Please make sure the input device is connected to the machine.';
    },
    TypeError: () => {
        return '<b>Cause: </b><br><code>navigator.mediaDevices</code> does not exist.<br>'
            + '<br><b>Solution: </b><br>If you\'re sure that the browser supports '
            + '<code>navigator.mediaDevices</code>, make sure your app is being served '
            + 'from a secure context (<code>localhost</code> or an <code>https</code> domain).';
    }
};

function getUserFriendlyError(error) {
    const errorName = [error.name, error.constructor.name].find(errorName => {
        return errorName in USER_FRIENDLY_ERRORS;
    });
    return errorName ? USER_FRIENDLY_ERRORS[errorName](error) : error.message;
}

function showError($modal, error) {
    // Add the appropriate error message to the alert.
    $('div.alert', $modal).html(getUserFriendlyError(error));
    $modal.modal({
        backdrop: 'static',
        focus: true,
        keyboard: false,
        show: true
    });
    
    $('#show-error-label', $modal).text(`${error.name}${error.message
        ? `: ${error.message}`
        : ''}`);
}

async function selectCamera() {
    if (deviceIds.video === null) {
        try {
            deviceIds.video = await selectMedia('video', $selectCameraModal, stream => {
                const $video = $('video', $selectCameraModal);
                $video.get(0).srcObject = stream;
            });
        } catch (error) {
            showError($showErrorModal, error);
            return;
        }
    }
    return joinRoom();
}

async function selectMicrophone() {
    if (deviceIds.audio === null) {
        try {
            deviceIds.audio = await selectMedia('audio', $selectMicModal, stream => {
                const $levelIndicator = $('svg rect', $selectMicModal);
                const maxLevel = Number($levelIndicator.attr('height'));
                micLevel(stream, maxLevel, level => $levelIndicator.attr('y', maxLevel - level));
            });
        } catch (error) {
            console.log(error)
            showError($showErrorModal, error);
            return;
        }
    }
    return selectCamera();
}

async function applyInputDevice(kind, deviceId, render) {
    // Create a new LocalTrack from the given Device ID.
    const [track] = await createLocalTracks({[kind]: {deviceId}});
    
    // Stop the previous LocalTrack, if present.
    if (localTracks[kind]) {
        localTracks[kind].stop();
    }
    
    // Render the current LocalTrack.
    localTracks[kind] = track;
    render(new MediaStream([track.mediaStreamTrack]));
}

async function getInputDevices(kind) {
    const devices = await navigator.mediaDevices.enumerateDevices();
    return devices.filter(device => device.kind === `${kind}input`);
}

async function selectMedia(kind, $modal, render) {
    const $apply = $('button', $modal);
    const $inputDevices = $('select', $modal);
    const setDevice = () => applyInputDevice(kind, $inputDevices.val(), render);
    
    // Get the list of available media input devices.
    let devices = await getInputDevices(kind);
    
    // Apply the default media input device.
    await applyInputDevice(kind, devices[0].deviceId, render);
    
    // If all device IDs and/or labels are empty, that means they were
    // enumerated before the user granted media permissions. So, enumerate
    // the devices again.
    if (devices.every(({deviceId, label}) => !deviceId || !label)) {
        devices = await getInputDevices(kind);
    }
    
    // Populate the modal with the list of available media input devices.
    $inputDevices.html(devices.map(({deviceId, label}) => {
        return `<option value="${deviceId}">${label}</option>`;
    }));
    
    return new Promise(resolve => {
        $modal.on('shown.bs.modal', function onShow() {
            $modal.off('shown.bs.modal', onShow);
            
            // When the user selects a different media input device, apply it.
            $inputDevices.change(setDevice);
            
            // When the user clicks the "Apply" button, close the modal.
            $apply.click(function onApply() {
                $inputDevices.off('change', setDevice);
                $apply.off('click', onApply);
                $modal.modal('hide');
            });
        });
        
        // When the modal is closed, save the device ID.
        $modal.on('hidden.bs.modal', function onHide() {
            $modal.off('hidden.bs.modal', onHide);
            
            // Stop the LocalTrack, if present.
            if (localTracks[kind]) {
                localTracks[kind].stop();
                localTracks[kind] = null;
            }
            
            // Resolve the Promise with the saved device ID.
            const deviceId = $inputDevices.val();
            deviceIds[kind] = deviceId
            //localStorage.setItem(`${kind}DeviceId`, deviceId);
            resolve(deviceId);
        });
        
        // Show the modal.
        $modal.modal({
            backdrop: 'static',
            focus: true,
            keyboard: false,
            show: true
        });
    });
}

// When we are about to transition away from this page, disconnect
// from the room, if joined.
window.addEventListener('beforeunload', leaveRoomIfJoined);
window.addEventListener('resize', resizeMobileVideo);

window.addEventListener('load', isSupported ? selectMicrophone : () => {
    showError($showErrorModal, new Error('This browser is not supported.'));
});


// Obtain a token from the server in order to connect to the Room.
function joinRoom() {
    if (deviceIds.audio === null || deviceIds.video === null) {
        return selectMicrophone()
    }
    
    /*connectOptions.tracks = await createLocalTracks();*/
    
    $.getJSON('/twilio-token', {room: roomName, call_type: callType, mobile: isMobile}, function (data) {
        
        if (!data.token) {
            updateStatus('Token Error : ' + data.message, statusContainer);
            return;
        }
        
        token = data.token;
        identity = data.identity;
        userId = data.user_id;
        classId = data.class_id
        
        // Add the specified audio device ID to ConnectOptions.
        connectOptions.audio = {
            deviceId: {exact: deviceIds.audio},
            logLevel: 'debug',
            workaroundWebKitBug180748: true
        };
        
        // Add the specified Room name to ConnectOptions.
        connectOptions.name = roomName;
        
        // Add the specified video device ID to ConnectOptions.
        connectOptions.video.deviceId = {exact: deviceIds.video};
        
        console.log(connectOptions)
        
        Video.connect(token, connectOptions).then(roomJoined, function (error) {
            updateStatus('Couldn\'t connect : ' + error.message, statusContainer);
            logCallError(`${identity} - ${userId}`, `Room  ${roomName} join error': ${error.message}`)
        });
        
        Chat.Client.create(token).then(initChatClient, function (error) {
            updateStatus('Couldn\'t init Chat Client : ' + error.message, chatConnectStatus);
        })
        
    });
}

// Successfully connected!
function roomJoined(room) {
    
    window.room = activeRoom = room;
    
    updateStatus('Joined Class', statusContainer)
    logCallError(`${identity} - ${userId}`, `Room ${activeRoom.sid} - Class ${classId} Connected`)
    
    controlButtonsContainer.style.display = 'block';
    //localVideoContainer.style.display = 'block';
    
    // Save the LocalVideoTrack.
    let localVideoTrack = Array.from(room.localParticipant.videoTracks.values())[0].track;
    
    participantConnected(room.localParticipant, room);
    
    // Attach the Tracks of the Room's Participants.
    room.participants.forEach(function (participant) {
        
        participantConnected(participant, room);
        
        participant.on('networkQualityLevelChanged', function () {
            updateNetworkQualityReport(participant);
        });
    });
    
    // When a Participant joins the Room
    room.on('participantConnected', function (participant) {
        participantConnected(participant, room);
        resizeVideo(room.participants.size);
        updateStatus(participant.identity.replace('(Mobile)', '') + ' joined', statusContainer);
        logCallError(`Partcipant ${participant.identity}`, `Room ${activeRoom.sid} - Class ${classId} Connected`)
        
        console.log(`No of Participants (connected): `, room.participants.size);
    });
    
    room.on('participantReconnecting', remoteParticipant => {
        console.log(`${remoteParticipant.identity} is reconnecting the signaling connection to the Room!`);
    });
    
    room.on('participantReconnected', remoteParticipant => {
        console.log(`${remoteParticipant.identity} has reconnected the signaling connection to the Room!`);
    });
    
    // When a Participant leaves the Room, detach its Tracks.
    room.on('participantDisconnected', function (participant) {
        
        detachParticipantTracks(participant);
        updateStatus(participant.identity.replace('(Mobile)', '') + ' disconnected', statusContainer);
        resizeVideo(room.participants.size);
        logCallError(`${participant.identity} - ${userId}`, `Room ${activeRoom.sid} - Class ${classId} disconnected : Participant disconnected`)
        
        console.log(`RemoteParticipant ${participant.identity} disconnected`);
        console.log(`No of Participants (disconnected): `, room.participants.size);
    });
    
    room.on('reconnecting', error => {
        updateStatus('Reconnecting Class, Please wait...', statusContainer);
        
        if (error) {
            logCallError(`${identity} - ${userId}`, `Error Room  ${activeRoom.sid} - Class ${classId}: ${error.code} - ${error.message}`)
            updateStatus(`Error : ${error.code} - ${error.message}`, statusContainer);
            console.log('Error: ', error.message);
        } else {
            updateStatus('Reconnected Class', statusContainer);
        }
    });
    
    room.on('reconnected', () => {
        updateStatus('Reconnected Class successfully', statusContainer);
        logCallError(`${identity} - ${userId}`, `Room ${activeRoom.sid} - Class ${classId} reconnected: Reconnected your signaling and media connections`)
        console.log('Reconnected your signaling and media connections!');
    });
    
    room.on('disconnected', function (room, error) {
        detachParticipantTracks(room.localParticipant);
        room.participants.forEach(detachParticipantTracks);
        $(chatMessageInput).prop('disabled', true);
        
        if (error) {
            logCallError(`${identity} - ${userId}`, `Error Room  ${activeRoom.sid} - Class ${classId}: ${error.code} - ${error.message}`)
            updateStatus(`Error : ${error.code} - ${error.message}`, statusContainer);
            console.log('Error: ', error.message);
        } else {
            updateStatus('Disconnected from class', statusContainer);
            logCallError(`${identity} - ${userId}`, `Room ${activeRoom.sid} - Class ${classId} disconnected : User left the room`)
        }
    });
    
    room.localParticipant.on('networkQualityLevelChanged', function () {
        updateNetworkQualityReport(room.localParticipant);
    });
    
    if (isMobile) {
        
        window.onpagehide = () => {
            //room.disconnect();
            location.reload()
        };
        
        // On mobile browsers, use "visibilitychange" event to determine when
        document.onvisibilitychange = async () => {
            if (document.visibilityState === 'hidden') {
                location.reload()
                // When the app is backgrounded, your app can no longer capture
                // video frames. So, stop and unpublish the LocalVideoTrack.
                //localVideoTrack.stop();
                //room.localParticipant.unpublishTrack(localVideoTrack);
            }
        };
    }
    
    $('#button-toggle-audio').removeClass("hidden")
    $('#button-toggle-video').removeClass("hidden")
}


// Get the Participant's Tracks.
function getTracks(participant) {
    return Array.from(participant.tracks.values()).filter(function (publication) {
        return publication.track;
    }).map(function (publication) {
        return publication.track;
    });
}

// Attach the Track to the DOM.
function attachTrack(track, participant) {
    
    
    if (track.name.toString().includes('screen')) {
        console.log('Screen')
        screenContainer = document.createElement('div');
        screenContainer.id = `participant-screen-${participant.sid}`;
        screenContainer.classList.add('participant-screen');
        screenContainer.style.position = 'relative';
        screenVideo = document.createElement('video');
        screenInfo = document.createElement('div')
        screenInfo.classList.add('status-info')
        screenInfo.classList.add('row')
        screenInfo.innerText = room.localParticipant === participant ? 'Your Screen' : participant.identity.replace('(Mobile)', '');
        
        screenContainer.appendChild(screenInfo);
        screenContainer.appendChild(screenVideo);
        
        if (room.localParticipant === participant) {
            shareScreenContainer.prepend(screenContainer)
        } else {
            shareScreenContainer.appendChild(screenContainer)
        }
        
        track.attach(screenVideo);
        
        if (!screenContainer.querySelector('div.participant-controls')) {
            
            $(screenVideo).after(`
            <div class="participant-controls">
                <button type="button" class="video-buttons btn-icon btn-danger endCallBtn bmd-btn-fab mx-3
                    button-participant-screen-fs" data-sid="${participant.sid}">
                                    <span><i class="la la-expand"></i></span>
                                </button>
            </div>
            `);
        }
        
        openScreens();
        
        return;
        
    }
    
    element = document.querySelector(`div#${participant.sid} > ${track.kind}`)
    
    if (element) {
        // Attach the Participant's Track to the thumbnail.
        const $media = $(`div#${participant.sid} > ${track.kind}`);
        $media.css('opacity', '');
        track.attach($media.get(0));
        resizeVideo(room.participants.size);
    }
    
}

function setupParticipantContainer(participant, room) {
    const {identity, sid} = participant;
    var $participants = $('div#participants')
    console.log('Setup', participant)
    
    // Add a container for the Participant's media.
    const $container = $(`<div class="participant participant-video ${identity.toString().includes('(Mobile)') ? 'mobile' : 'desktop'}" data-identity="${identity}" id="${sid}">
                            <audio autoplay ></audio>
                            <video autoplay muted playsinline style="width: 100%;"></video>
                          </div>`);
    
    // Add the Participant's container to the DOM.
    if (room.localParticipant === participant) {
        $participants.prepend($container);
        
    } else {
        $participants.append($container);
    }
    addParticipantDetails(participant)
    
}

function addParticipantDetails(participant) {
    
    var videoElement = document.querySelector(`div#${participant.sid} > video`)
    var container = document.querySelector(`div#${participant.sid}`)
    
    if (!container.querySelector('div.participant-controls')) {
        
        $(videoElement).after(`
                <button type="button" class="video-buttons btn-icon btn-danger endCallBtn bmd-btn-fab mx-3
                    button-participant-fs" data-sid="${participant.sid}">
                                    <span><i class="la la-expand"></i></span>
                                </button>
                <div class="participant-controls">
                    <div class=" ">${participant.identity.replace('(Mobile)', '')}</div>
                    <!--<div class=" ">Network Stats <i class="fa fa-eye show-network-details"></i></div>-->
                </div>
                <div class="network-stats">
                     <div class="row"><i class="fa fa-eye-slash hide-network-details"></i></div>
                     <div class="row">
                        <div class="col-lg-4 col-md-4">Overall : </div>
                        <div class="col-lg-7 col-md-7 quality-indicator">
                            <div class="quality-level" id="network-quality-${participant.sid}"></div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-4 col-md-4">Audio <small>(received)</small>: </div>
                        <div class="col-lg-7 col-md-7 quality-indicator">
                            <div class="quality-level" id="audio-recv-quality-${participant.sid}"></div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-lg-4 col-md-4">Audio <small>(sent)</small>: </div>
                        <div class="col-lg-7 col-md-7 quality-indicator">
                            <div class="quality-level" id="audio-sent-quality-${participant.sid}"></div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-lg-4 col-md-4">Video <small>(received)</small>: </div>
                        <div class="col-lg-7 col-md-7 quality-indicator">
                            <div class="quality-level" id="video-recv-quality-${participant.sid}"></div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-lg-4 col-md-4">Video <small>(sent)</small>: </div>
                        <div class="col-lg-7 col-md-7 quality-indicator">
                            <div class="quality-level" id="video-sent-quality-${participant.sid}"></div>
                        </div>
                     </div>
                </div>
            `);
    }
    
}


// A new RemoteTrack was published to the Room.
function trackPublished(publication, participant) {
    
    // If the TrackPublication is already subscribed to, then attach the Track to the DOM.
    if (publication.track) {
        attachTrack(publication.track, participant);
    }
    
    // Once the TrackPublication is subscribed to, attach the Track to the DOM.
    publication.on('subscribed', track => {
        attachTrack(track, participant);
    });
    
    // Once the TrackPublication is unsubscribed from, detach the Track from the DOM.
    publication.on('unsubscribed', track => {
        detachTrack(track, participant);
    });
}

// A new RemoteParticipant joined the Room
function participantConnected(participant, room) {
    
    // Set up the Participant's media container.
    setupParticipantContainer(participant, room);
    
    // Handle the TrackPublications already published by the Participant.
    participant.tracks.forEach(publication => {
        trackPublished(publication, participant);
    });
    
    // Handle theTrackPublications that will be published by the Participant later.
    participant.on('trackPublished', publication => {
        trackPublished(publication, participant);
    });
    
    participant.on('trackUnpublished', trackUnpublished);
}

// A RemoteTrack was unpublished from the Room.
function trackUnpublished(publication) {
    console.log(publication.kind + ' track was unpublished.');
}

function detachTrack(track, participant) {
    
    if (track.name.toString().includes('screen')) {
        $(`div#participant-screen-${participant.sid}`).remove()
    } else {
        var $participants = $('div#participants')
        const $media = $(`div#${participant.sid} > ${track.kind}`, $participants);
        $media.css('opacity', '0');
        track.detach($media.get(0));
        $(`div#${participant.sid}`).remove()
    }
    
}

// Detach the Participant's Tracks from the DOM.
function detachParticipantTracks(participant) {
    var tracks = getTracks(participant);
    var $participants = $('div#participants')
    
    tracks.forEach(function (track) {
        const $media = $(`div#${participant.sid} > ${track.kind}`, $participants);
        $media.css('opacity', '0');
        track.detach($media.get(0));
        detachTrack(track, participant)
    });
}

// Update status
function updateStatus(message, container) {
    container.innerHTML = message;
}


// Updates the Network Quality report for a Participant
function updateNetworkQualityReport(participant) {
    network = document.getElementById(`network-quality-${participant.sid}`);
    audioSent = document.getElementById(`audio-sent-quality-${participant.sid}`);
    audioReceived = document.getElementById(`audio-recv-quality-${participant.sid}`);
    videoSent = document.getElementById(`video-sent-quality-${participant.sid}`);
    videoReceived = document.getElementById(`video-recv-quality-${participant.sid}`);
    
    if (participant.networkQualityStats) {
        if (participant.networkQualityStats.level < 3) {
            logCallError(`${participant.identity}`,
                `Room ${activeRoom.sid} - Class ${classId} Network Quality: ${participant.networkQualityStats.level}
            - Audio sent: ${participant.networkQualityStats.audio.send}
            - Audio received: ${participant.networkQualityStats.audio.recv}
            - Video sent: ${participant.networkQualityStats.video.send}
            - Video received: ${participant.networkQualityStats.video.recv}`)
        }
        network.style.width = `${participant.networkQualityStats.level * 20}%`;
        audioSent.style.width = `${participant.networkQualityStats.audio.send * 20}%`;
        audioReceived.style.width = `${participant.networkQualityStats.audio.recv * 20}%`;
        videoSent.style.width = `${participant.networkQualityStats.video.send * 20}%`;
        videoReceived.style.width = `${participant.networkQualityStats.video.recv * 20}%`;
    } else {
        network.style.width = `0%`;
        audioSent.style.width = `0%`;
        audioReceived.style.width = `0%`;
        videoSent.style.width = `0%`;
        videoReceived.style.width = `0%`;
    }
}

// Remote partipant video Full screen
$('body').on('click', 'button.button-participant-fs', function () {
    sid = $(this).data('sid');
    container = document.getElementById(`${sid}`);
    let videoElement = container.querySelector('video');
    toggleFullScreen(videoElement);
});

// Remote partipant video Full screen
$('body').on('click', 'button.button-participant-screen-fs', function () {
    sid = $(this).data('sid');
    container = document.getElementById(`participant-screen-${sid}`);
    let videoElement = container.querySelector('video');
    toggleFullScreen(videoElement);
});

// Full screen preview video
document.getElementById('button-full-screen').onclick = function () {
    videoElement = document.querySelector(`div#${room.localParticipant.sid} > video`);
    toggleFullScreen(videoElement);
}


// Screen share button click
document.getElementById('button-share-screen').onclick = async function () {
    try {
        // Create and preview your local screen.
        screenTrack = await createScreenTrack(1080, 1920);
        
        room.localParticipant.publishTrack(screenTrack);
        
        // Show the "Capture Screen" button after screen capture stops.
        screenTrack.on('stopped', function () {
            stopShareScreen();
            toggleShareScreenButtons();
        });
        
        // Show the "Stop Capture Screen" button.
        toggleShareScreenButtons();
    } catch (e) {
        alert(e.message);
    }
};

// Stop share button click
document.getElementById('button-stop-share-screen').onclick = function () {
    // Stop capturing your screen.
    toggleShareScreenButtons();
    //screenTrack.stop();
    stopShareScreen();
}

// Resize video size depends on no of participant
function resizeVideo(remoteParticipants) {
    allParticipants = remoteParticipants + 1;
    
    console.log(callType)
    console.log(allParticipants)
    
    if (callType === 'free_call' && allParticipants >= 2 && initCounter === false) {
        initCounter = true;
        console.log('Init call duration')
        counterTimer = setInterval(function () {
            updateCallDuration()
        }, MILLLISECONDS_IN_MINUTE)
    }
    
    if (callType === 'free_call' && allParticipants < 2) {
        if (counterTimer) {
            console.log('Clear interval at ' + callDuration + 'mins')
            clearInterval(counterTimer)
        }
        initCounter = false
    }
    
    resizeMobileVideo()
    
}

function resizeMobileVideo() {
    // resize video of mobile
    allParticipants = room ? room.participants.size + 1 : 1
    
    if (!isMobile) {
        
        if (allParticipants == 1) {
            $('div.participant-video').removeClass('col-lg-6');
            $('div.participant-video').removeClass('col-md-6');
            $('div.participant-video').removeClass('col-lg-4');
            $('div.participant-video').removeClass('col-md-4');
            $('div.participant-video').addClass('col-lg-12');
            $('div.participant-video').addClass('col-md-12');
        }
        else if (allParticipants >= 2 && allParticipants < 5) {
            $('div.participant-video').removeClass('col-lg-12');
            $('div.participant-video').removeClass('col-md-12');
            $('div.participant-video').removeClass('col-lg-4');
            $('div.participant-video').removeClass('col-md-4');
            $('div.participant-video').addClass('col-lg-6');
            $('div.participant-video').addClass('col-md-6');
        } else {
            $('div.participant-video').removeClass('col-lg-12');
            $('div.participant-video').removeClass('col-md-12');
            $('div.participant-video').removeClass('col-lg-6');
            $('div.participant-video').removeClass('col-md-6');
            $('div.participant-video').addClass('col-lg-4');
            $('div.participant-video').addClass('col-md-4');
        }
        
        if (allParticipants >= 2) {
            var desktopVideos = $('div.participant-video.desktop');
            if (desktopVideos.length) {
                let maxHeight = 0;
                $('div.participant-video.desktop > video').each(function () {
                    let video = $(this)
                    if (video.height() > maxHeight) {
                        maxHeight = video.height()
                    }
                })
                console.log('Max Height', maxHeight)
                
                $('div.participant-video.mobile > video').css('height', `${maxHeight}px`)
                $('div.participant-video').css('height', `${maxHeight + 28}px`)
            }
        } else {
            $('div.participant-video > video').css('height', `auto`)
            $('div.participant-video').css('height', `auto`)
        }
        
    }
    
}

// Create local screen track
function createScreenTrack(height, width) {
    if (typeof navigator === 'undefined'
        || !navigator.mediaDevices
        || !navigator.mediaDevices.getDisplayMedia) {
        return Promise.reject(new Error('getDisplayMedia is not supported by your Browser. ' +
            'Supported Browsers : Chrome 72+, Firefox 66+ and Safari 12.2+. Please update' +
            ' you browser to enable Share Screen'));
    }
    return navigator.mediaDevices.getDisplayMedia({
        video: {
            height: height,
            width: width
        }
    }).then(function (stream) {
        return new Video.LocalVideoTrack(stream.getVideoTracks()[0],
            {name: `${identity.replace('(Mobile)', '')}'s screen`});
    });
}

// Stop screen share
function stopShareScreen() {
    $(`div#participant-screen-${room.localParticipant.sid}`).remove()
    
    if (screenTrack) {
        room.localParticipant.unpublishTrack(screenTrack);
        //const attachedElements = screenTrack.detach();
        /*attachedElements.forEach(element => {
            if (element.parent('div')) {
                element.parent('div').remove();
                element.remove();
            }
        });*/
        screenTrack = null;
    }
}

function toggleLocalParticipantAudio() {
    var localParticipant = room ? room.localParticipant : null
    
    audioEnabled = !audioEnabled;
    var title = audioEnabled ? "Mute Mic" : "Unmute Mic"
    $("#button-toggle-audio").toggleClass("muted")
    $("#button-toggle-audio span span").html(title)
    
    if (!localParticipant) {
        return
    }
    
    localParticipant.audioTracks.forEach(function (audioTrack) {
        console.log("audioTrack-- " + audioTrack);
        if (audioEnabled) {
            audioTrack.track.enable();
        }
        else {
            audioTrack.track.disable();
        }
    });
}

function toggleLocalParticipantVideo() {
    var localParticipant = room ? room.localParticipant : null
    
    videoEnabled = !videoEnabled;
    
    var title = videoEnabled ? "Disable Video" : "Enable Video"
    $("#button-toggle-video").toggleClass("muted")
    $("#button-toggle-video span span").html(title)
    if (!localParticipant) {
        return
    }
    
    localParticipant.videoTracks.forEach(function (videoTrack) {
        console.log("videoTracks-- " + videoTrack);
        if (videoEnabled) {
            videoTrack.track.enable();
        }
        else {
            videoTrack.track.disable();
        }
    });
}

function toggleShareScreenButtons() {
    document.getElementById('button-share-screen').style.display = document.getElementById('button-share-screen').style.display === 'none' ? '' : 'none';
    document.getElementById('button-stop-share-screen').style.display = document.getElementById('button-stop-share-screen').style.display === 'none' ? '' : 'none';
}

// End call
function endCall() {
    if (activeRoom) {
        logCallError(`${identity.replace('(Mobile)', '')} - ${userId}`, `Room ${activeRoom.sid} - Class ${classId} disconnected :  Leave/End call click`)
        activeRoom.disconnect();
    }
    
    if (chatChannel) {
        leaveChatChannel();
    }
}

// Leave Room on window unload
function leaveRoomIfJoined() {
    if (activeRoom) {
        logCallError(`${identity.replace('(Mobile)', '')} - ${userId}`, `Room ${activeRoom.sid} - Class ${classId} disconnected :  Tab close or refresh (window.beforeunload)`)
        activeRoom.disconnect();
    }
    
    if (chatChannel) {
        leaveChatChannel();
    }
}

// Leave Room
function leaveRoom() {
    controlButtonsContainer.style.display = 'none';
    //updateStatus('', shareScreenInfoContainer)
    stopShareScreen();
    endCall();
}

// Leave room button click
document.getElementById('button-leave-room').onclick = function () {
    leaveRoom();
    leaveChatChannel();
    window.location = "/";
};

document.getElementById('button-toggle-audio').onclick = function () {
    toggleLocalParticipantAudio();
};

document.getElementById('button-toggle-video').onclick = function () {
    toggleLocalParticipantVideo();
};

// Toggle full screen
function toggleFullScreen(videoElement) {
    console.log(videoElement);
    if (!document.mozFullScreen && !document.webkitFullScreen) {
        if (videoElement.mozRequestFullScreen) {
            videoElement.mozRequestFullScreen();
        } else {
            videoElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else {
            document.webkitCancelFullScreen();
        }
    }
}

// Chat messaging
function initChatClient(client) {
    console.log(`Chat client init ${client}`)
    chatClient = client;
    chatClient.on('channelJoined', function (channel) {
        chatChannel = channel;
        console.log('Joined channel ' + channel.uniqueName)
    })
    
    chatClient.getChannelByUniqueName(roomName)
        .then(function (channel) {
            chatChannel = channel;
            return joinChannel(chatChannel);
            
        }).then(initChannelEvents)
        .catch(err => {
            console.log(`Get channel error : ${err}`);
            
            // Create new channel
            chatClient.createChannel({
                friendlyName: 'Classhub Chat ' + roomName,
                isPrivate: false,
                uniqueName: roomName,
            }).then(function (channel) {
                chatChannel = joinChannel(channel);
                return chatChannel;
            }).then(initChannelEvents)
                
                .catch(err => {
                    console.log(`channel error :  ${err}`)
                })
        });
    
    chatMessageInput.onkeypress = sendMessage;
    sendMessageButton.onclick = sendMessageWithButton;
    attachmentInput.onchange = sendMediaMessage;
}

function joinChannel(channel) {
    
    return channel.join()
        .then(function (joinedChannel) {
            console.log(`${identity} Joined channel ${joinedChannel.friendlyName}`);
        }).catch(function (error) {
            if (channel.status == 'joined') {
                return channel;
            } else {
                updateStatus(`Unable to join channel:  ${error}`, chatConnectStatus);
                console.log(`${identity} couldn't join channel. Error:  ${error}`);
            }
        });
}

function initChannelEvents() {
    chatChannel.on('messageAdded', addMessageToList);
    chatChannel.on('typingStarted', showTypingStarted);
    chatChannel.on('typingEnded', hideTypingStarted);
    $($messageContainer).html('');
    console.log('Init channel events')
}

function leaveChatChannel() {
    if (chatChannel) {
        chatChannel.leave();
    }
}

function sendMessage(event) {
    if (chatChannel) {
        if (event.keyCode === 13 && $(chatMessageInput).val() != '') {
            chatChannel.sendMessage($(chatMessageInput).val());
            event.preventDefault();
            $(chatMessageInput).val('');
        }
        else {
            console.log('Notify typing calling')
            notifyTyping();
        }
    }
}

function sendMessageWithButton() {
    if (chatChannel) {
        chatChannel.sendMessage($(chatMessageInput).val());
        event.preventDefault();
        $(chatMessageInput).val('');
    }
}

function sendMediaMessage() {
    if (chatChannel) {
        console.log(this.files[0]);
        
        if (this.files[0].size > MAX_FILE_SIZE) {
            alert('Max File size is 150MB');
            return;
        }
        
        const formData = new FormData();
        formData.append('file', this.files[0]);
        sendingFileId = Math.floor(Math.random() * Math.floor(9999999));
        $($messageContainer).append(
            `<div class="message message-out" id="file-sent-${sendingFileId}">
            Sending File(${this.files[0].name})...
        </div>
    `);
        chatChannel.sendMessage(formData);
    }
}

var notifyTyping = $.throttle(function () {
    chatChannel.typing();
}, 1000);


function addMessageToList(message) {
    console.log(message);
    
    className = message.author == identity ? 'message-out' : 'message-in';
    
    if (message.type === 'media') {
        if (message.author == identity) {
            message.media.getContentTemporaryUrl().then(function (url) {
                $(`div#file-sent-${sendingFileId}`).html(
                    `<a href="${url}" target="_blank" style="color:white">
                        <i id="button-send-file" class="fa fa-paperclip" style="color: white; font-size: 20px;"></i>
                            File sent "${message.media.filename}"</a>
                `);
            });
        } else {
            message.media.getContentTemporaryUrl().then(function (url) {
                $($messageContainer).append(
                    `<div class="message ${className}">
                    <div class=""><a href="${url}" target="_blank">
                       <i id="button-send-file" class="fa fa-paperclip" style="font-size: 20px;"></i>
                        Download "${message.media.filename}"</a>
                        <span class="chat-user-name"><i class="fa fa-user"></i>  ${message.author.replace('(Mobile)', '')}</span>
                 </div>
            `);
            });
        }
        
    } else {
        $($messageContainer).append(`
        <div class="message ${className}">
            <div class="">${message.body}</div>
            <span class="chat-user-name"><i class="fa fa-user"></i>  ${message.author.replace('(Mobile)', '')}</span>
        </div>`);
    }
    
    if ($('#chat-container').width() == 0) {
        var unreadMessagesNo = parseInt($('#video-notification-counter').html()) + 1
        $('#video-notification-counter').html(unreadMessagesNo)
        $('.video-notification-counter').show()
    }
    
    scrollToMessageBottom();
}

function scrollToMessageBottom() {
    $($messageContainer).scrollTop($($messageContainer).height() + 50);
}

function showTypingStarted() {
    typingContainer.style.display = 'block'
}

function hideTypingStarted() {
    typingContainer.style.display = 'none'
}
