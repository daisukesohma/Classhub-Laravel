<script type="text/javascript">

    function updateScrollSentMessage() {
        var element = document.getElementById("chat-messages-box");
        element.scrollTop = element.scrollHeight;
    }

    $(document).ready(function () {

        var messageContainer = $('div.kt-chat__messages');

        var safari = navigator.userAgent.indexOf("Safari") > -1;

        //if (!safari) {
        $(messageContainer).parents('div').scrollTop($(messageContainer).height())
        //}

        // Send Chat Message
        $('body').on('click', 'a.chat-send', function (e) {
            var message = $('input[name="chat-message"]').val()
            if (message.length !== 0) {
                sendMessage(message)
            }
        })

        $('body').on('keyup', 'input[name="chat-message"]', function (e) {
            var message = $(this).val()
            if (e.keyCode == 13 && message.length !== 0) {
                sendMessage(message)
            }
        })

        // Send Files
        $('body').on('change', 'input[name="attachment"]', function (e) {
            var file = document.getElementById('file-input').files[0];
            sendFile(file);
        })

        function sendMessage(message) {
            $.ajax({
                type: 'POST',
                url: '{{ route('chat.send.message') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    text: message,
                    lesson_id: $('a.chat-send').data('lesson-id'),
                    recipient_id: $('a.chat-send').data('recipient-id'),
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $('input[name="chat-message"]').val('')

                        $('div.kt-chat__messages').append(
                            `<div class="kt-chat__message kt-chat__message--right">
                                <div class="kt-chat__text kt-bg-light-brand">
                                    <p>${message}</p>
                                    <span class="kt-chat__datetime">${data.time}</span>
                                </div>
                            </div>`)

                        $(messageContainer).parents('div').scrollTop($(messageContainer).height())

                        updateScrollSentMessage()

                    } else if (data.personal_info) {
                        $('input[name="chat-message"]').val('')

                        $('div.kt-chat__messages').append(
                            `<div class="kt-chat__message kt-chat__message--right">
                                <div class="kt-chat__text kt-bg-light-brand">
                                    <p>${message}</p>
                                    <span class="kt-chat__datetime">${data.time}</span>
                                    <div class="not-sent">
                                        <i class="fa fa-exclamation-circle"></i> Not sent
                                    </div>
                                </div>
                            </div>`)

                        $('div.kt-chat__messages').append(
                            `<div class="inbox-error"><p class="personal-info-error">${data.messages.join(' ')}</p></div>`)
                        $(messageContainer).parents('div').scrollTop($(messageContainer).height())

                        updateScrollSentMessage()

                    } else {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        $(resultModal).modal('show')
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            })

        }

        function sendFile(file) {
            const formData = new FormData();
            formData.append('_token', '{{csrf_token()}}')
            formData.append('type', 'file');
            formData.append('file', file);
            formData.append('lesson_id', $('a.chat-send').data('lesson-id'));
            formData.append('recipient_id', $('a.chat-send').data('recipient-id'));

            $.ajax({
                type: 'POST',
                url: '{{ route('chat.send.message') }}',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'JSON',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $('input[name="attachment"]').val('')

                        $('div.kt-chat__messages').append(
                            `<div class="kt-chat__message kt-chat__message--right">
                                <div class="kt-chat__text kt-bg-light-brand">
                                    <p>
                                        <a href="{{ url('/download/message/${data.chat_message.id}') }}" target="_blank" style="color: #212121;">
                                            <i id="button-send-file" class="fa fa-paperclip" style="color: #212121; font-size: 20px;"></i>
                                            ${file.name}
                                        </a>
                                    </p>
                                    <span class="kt-chat__datetime">${data.time}</span>
                                </div>
                            </div>`)

                        $(messageContainer).parents('div').scrollTop($(messageContainer).height())

                        updateScrollSentMessage()

                    } else {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        $(resultModal).modal('show')
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            })

        }
    })
</script>
