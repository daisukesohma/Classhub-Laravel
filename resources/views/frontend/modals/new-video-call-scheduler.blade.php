

<div class="modal fade c-modal v1" id="new-video-call-scheduler" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-b-0">
                <h5 class="text-center" style="width: 100%">Schedule Video Call</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body text-center p-lr-42 p-tb-0">
                Please choose a date and time to suggest a video call {{--with
                <strong>{{  \App\User::withTrashed()->find($futureCallWith[0]['user_id'])->name }}</strong>:--}}
                <form>
                    <div class="row" style="padding-top: 30px">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <input
                                type="text"
                                class="form-control schedule-time-picker"
                                placeholder="Date / Time"
                                name="new_video_call_time">
                            <a class="btn btn-sm btn-primary v2 shadow-v4 new-schedule-call-btn" href="javascript:void
                                (0);" data-dismiss="modal"
                            ><span class="btn__text v1 fw-6">Schedule Call</span>
                            </a>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('css/flatpickr.css') }}" rel="stylesheet" type="text/css" media="all"/>
<script src="{{ asset('js/flatpickr.js') }}"></script>

<script type="text/javascript">

    $(function () {
        $('input.schedule-time-picker').flatpickr({
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            minDate: "{!! date('d-m-Y H:i') !!}"
        })

        $('body').on('click', 'a.new-schedule-call-btn', function () {
            $(resultModal).modal('show')
            $.ajax({
                type: 'POST',
                url: '{{ route('schedule.call') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    time: $('input[name="new_video_call_time"]').val(),
                    text: 'Hi there, I would like to schedule a video call for:',
                    recipient_id: recipientId,
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    } else {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                },
                error: function (data) {
                    console.log(data)
                    //$(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            })
        })

    })

</script>
