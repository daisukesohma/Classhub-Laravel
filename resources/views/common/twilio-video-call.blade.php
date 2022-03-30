<style type="text/css">
    #status, #ss-title {
        color: #fff;
        background-color: #E74B65;
        border-color: #E74B65;
        padding: 6px 12px;
        border-radius: 0px;
        font-weight: 400;
        margin-bottom: 0px;
        color: #ffffff;
        text-transform: uppercase;
        font-weight: bold;
    }

    #call-screen {
        min-height: 400px;
        position: relative;
    }

    #call-screen video {
        display: block !important;
        margin: 0 auto;
        max-width: 100%;
        min-height: 60%;
    }

    .call-info {
        width: 100%;
        text-align: center;
    }

    .call-info div {
        margin: 20px auto;
    }

    .call-user-info {
        font-weight: bold;
        font-size: 20px;
    }

    .active-call-photo {
        border: 2px solid #E74B65;
        animation: shadow-pulse 1s infinite;
    }

    .call-actions {
        margin: auto;
    }

    .accept-call {
        border: 1px solid #E74B65 !important;
        color: #E74B65 !important;
        margin-left: 10px;
        display: inline-block !important;
    }

    .reject-call {
        display: inline-block;
    }

    #controls-container {
        position: absolute !important;
        bottom: 20px !important;
        width: 100%;
    }

    /*@media (min-width: 650px) {*/
    /**/
    /*}*/
    /*@media (max-width: 700px) {*/
    /*.accept-call {*/
    /*width: 100% !important;*/
    /*display: block !important;*/
    /*margin-bottom: 10px;*/
    /*}*/
    /*.reject-call {*/
    /*width: 100% !important;*/
    /*display: block !important;*/
    /*margin-bottom: 10px;*/
    /*}*/
    /*}*/
    /*@media (max-width: 600px) {*/
    /*#media-container {*/
    /*margin-top: 30px;*/
    /*margin-bottom: 30px;*/
    /*}*/
    /*}*/
</style>

@if($videoCall)

    <div class="modal fade c-modal v1" id="video-call-container" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document"
             style="width: 90%; max-width: 90%; margin: 30px auto!important;">
            <div class="modal-content">
                <div class="modal-header p-b-0">
                    <h4 class="text-center" style="width: 100%"> Video Call</h4>
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding-left: 0px; padding-right: 0px; padding-bottom: 0px;">
                    <div id="status"></div>
                    <div id="call-screen">
                        <div class="call-info" id="callee" style="display: none;">
                            <div class="profile-page-image active-call-photo"
                                 style="background-image: url({{ $callees[0]['photo'] }});"></div>
                            <div class="call-user-info">Waiting for "{{ $callees[0]['name'] }}" to
                                join...
                            </div>
                        </div>
                        <div id="remote-video">
                        </div>
                        <div id="controls-container" class="d-flex justify-content-center">
                            <div id="toolbars" style="visibility: hidden;">
                                <div style="position: relative" class="d-flex justify-content-center">
                                    {{--<button type="button" class="btn btn-secondary muteBtn bmd-btn-fab"
                                            id="mute-unmute">
                                        <span style="color:#222!important">
                                            <i class="la la-microphone-slash"></i>
                                            <span>Mute Audio</span>
                                        </span>
                                    </button>--}}
                                    <button type="button" class="btn btn-danger endCallBtn bmd-btn-fab mx-3"
                                            id="button-leave-room">
                                        <span><i class="la la-ban"></i>Leave Room</span>
                                    </button>
                                    <button type="button" class="btn btn-danger endCallBtn bmd-btn-fab mx-3"
                                            id="button-full-screen" style="display: none;">
                                        <span><i class="la la-expand"></i>Full Screen</span>
                                    </button>
                                    <button type="button" class="btn btn-danger  bmd-btn-fab mx-3"
                                            id="button-share-screen">
                                        <span><i class="la la-share"></i>
                                            <span id="share-screen-text">
                                                Share Screen
                                            </span>
                                        </span>
                                    </button>
                                    <button type="button" class="btn btn-danger  bmd-btn-fab mx-3"
                                            id="button-stop-share-screen" style="display: none;">
                                        <span><i class="la la-share"></i> Stop Screen Share</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="share-screen-container" style="margin-top: 20px">
                        <div id="ss-title-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type='text/javascript'>
        var roomName = '{{ $callees[0]['channel'] }}';
        var calleeName = '{{ $callees[0]['name'] }}';
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('div#call-scheduled').modal('show')
        })


    </script>
    <script type="text/javascript" src="{{ asset('twilio/index.js') }}"></script>



@endif
