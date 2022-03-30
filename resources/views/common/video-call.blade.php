@if(Auth::user() && Route::currentRouteName() !== 'page.video-call')
    <script type="text/javascript">
        var scheduleId;
        var url = '{{ route('home') }}/video-call/'
        $(function () {
            $.ajax({
                type: 'POST',
                url: '{{ route('user.video.schedule') }}',
                data: {_token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        scheduleId = data.schedule_id;
                        $('strong#lesson-name').html(data.lesson_name);

                        if (data.meeting_link) {
                            $('a#join-room').attr('href', data.meeting_link);
                            $('a#join-room').attr('target', '_blank');
                        } else {
                            $('a#join-room').attr('href', '{{ route('home') }}' + /video-call/ + data.class_id);
                        }

                        $('div#call-scheduled-modal').modal('show');
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            });
        })

        $('body').on('click', 'button#button-dismiss-call', function () {
            console.log(scheduleId);
            $.ajax({
                type: 'POST',
                url: '{{ route('schedule.call.dismiss') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    message_id: scheduleId,
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                },
                error: function (data) {
                    console.log(data)
                }
            })
        });

        function hideJoinCall() {
            $('.call-schedule-button-container').hide()
            $('.call-schedule-mobile-warning').show()
        }

        function isMobile() {
            const toMatch = [
                /Android/i,
                /webOS/i,
                /iPhone/i,
                /iPad/i,
                /iPod/i,
                /BlackBerry/i,
                /Windows Phone/i
            ];

            return toMatch.some((toMatchItem) => {
                return navigator.userAgent.match(toMatchItem);
            });
        }
    </script>

    <div class="modal fade c-modal v1" id="call-scheduled-modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document" style="margin-top: 20%">
            <div class="modal-content">
                <div class="modal-body" style="padding: 0px 45px 25px 45px">
                    <button type="button" class="close " data-dismiss="modal" aria-label="Close"
                            style="border: 1px solid #222; border-radius: 100px; height:20px; width: 20px; margin: 20px">
                                    <span aria-hidden="true">
                                      &times;
                                    </span>
                    </button>
                    <div class="row call-details text-center" style="margin: 30px auto">
                        <p style="font-size: 20px; margin-top: 20px">You have an online lesson</p>
                    </div>
                    <div class="row call-schedule-button-container">
                        <div class="col-md-12">
                            <a class="btn btn-primary" style="width: 100%;font-size: 20px;padding: 10px;"
                               id="join-room" href="">Join
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="row call-schedule-button-container">
                        <div class="col-md-12">
                            <button class="btn btn-primary" id="button-dismiss-call"
                                    style="width: 100%;font-size: 20px;padding: 10px;"
                                    data-dismiss="modal">Dont
                                show this again.
                            </button>
                        </div>
                    </div>
                    <img src="{{ asset('system-emails/powered-by-zoom.png') }}" alt="powered by zoom" height="20px" style="display: block; margin: 20px auto" />
                    {{--<div class="row call-details text-center call-schedule-mobile-warning only-mobile" style="margin: 30px auto;">
                        <div class="col-lg-12 col-md-12">
                            <span>To join this call please use a Desktop/Laptop.</span>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>


@endif
