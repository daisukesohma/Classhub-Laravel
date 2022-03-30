<!-- starts : titles -->
<div class="title">Class Details</div>
<div class="sub-title">
    <span id="className">{{ $lessons->first()->name }}</span> -
    <span class="participants"><span
            id="count">{{ $lessons->count() }}</span> participants</span>
</div>
<!-- end : titles -->

<!-- starts : table -->
<div class="classes-data">

    <!-- Starts : table data -->
    <div class="m-scrollable" data-scrollable="true" data-max-height="228">

        <table class="table data">

            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>

            <!-- starts: list 01 -->
            @foreach($lessons as $lesson)
                @foreach($lesson->bookings as $booking)
                    <tr>
                        <td style="width: 50%">{{ $booking->student_name ? $booking->student_name : $booking->user->name }}</td>
                        <td class="live" style="width: 50%">

                            @if($booking->status === 'cancelled')
                                Cancelled
                            @else
                                <a href="javascript:void(0)" data-recipient-id="{{ $booking->user_id }}"
                                   data-toggle="modal" data-target="#send-message-modal" data-dismiss="modal"
                                   data-lesson-id="{{ $booking->lesson_id }}"
                                   class="la la-envelope message-user-btn" title="Message"></a>

                                @if($lesson->status === 'live')
                                    <a href="javascript:void(0)" class="la la-arrow-right move-class-modal-btn"
                                       data-toggle="modal" data-target="#move-class-modal" data-dismiss="modal"
                                       data-booking-id="{{ $booking->id }}" data-parent-id="{{ $booking->user_id }}"
                                       data-route="{{ route('educator.move.class.modal') }}" title="Move Class"></a>
                                @endif

                                <a href="javascript:void(0)" class="la la-rotate-left rebook-modal-btn"
                                   data-toggle="modal" data-target="#subject-booking-modal"
                                   data-dismiss="modal"
                                   data-recipient-id="{{ $booking->user_id }}"
                                   title="Rebook"></a>


                                @if($lesson->status === 'live' && !$lesson->deleted_at)
                                    <a href="javascript:void(0)" class="la la-trash cancel-set-route-btn"
                                       data-dismiss="modal"
                                       data-toggle="modal"
                                       data-route="{{ route('educator.lesson.cancel',$lesson->id) }}"
                                       data-target="#cancel-class-modal" title="Cancel Class"></a>
                            @endif
                        @endif
                        <!-- end : action links -->
                        </td>
                    </tr>

                    <tr class="see-class">
                        <td colspan="3" style="padding: 0">
                            <table style="width: 100%; margin-bottom: 0">
                                <tbody>
                                @foreach($booking->classes as $bookingClass)
                                    <tr>
                                        <td class="user-class-list"><i
                                                class="fa fa-check-circle-o"></i>
                                            Class:
                                            {{ $bookingClass->class->day }}
                                            {{ \Carbon\Carbon::parse($bookingClass->class->date)->format('d M Y') }}
                                            ({{ \Carbon\Carbon::parse($bookingClass->class->start_time)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($bookingClass->class->end_time)->format('H:i') }}
                                            )
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </td>
                    </tr>
                    {{--@endif--}}
                @endforeach
            @endforeach
            </tbody>

        </table>

    </div>
    <!-- end : table data -->


</div>


<!-- end : table -->
<!--end::Modal-->
<style type="text/css">
    td.user-class-list {
        padding-left: 25px !important;
        padding-top: 15px !important;
        padding-bottom: 5px !important;
    }

    td.user-class-list::before {
        content: none !important;
        position: relative;
    }
</style>
<script type="text/javascript">
    $('body').on('click', 'a.rebook-modal-btn', function () {
        $('input#recipient-id').val($(this).data('recipient-id'))
    })

</script>
