<!-- starts : titles -->
<div class="title">Class Details</div>
<div class="sub-title">
    <span id="className">{{ $lesson->name }}</span> -
    <span class="participants"><span
            id="count">{{ $bookings ? $bookings->where('status', '!=', 'cancelled')->count() : 0 }}</span> participants</span>
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
                <th>Message</th>
                @if($lesson->max_num_bookings == 1  && $lesson->status == 'live')
                    <th>Move Class</th>
                @endif
            </tr>
            </thead>

            <tbody>

            <!-- starts: list 01 -->
            @foreach($bookings as $booking)
                @if($booking->status !== 'cancelled')
                    <tr>
                        <td>{{ $booking->student_name ? $booking->student_name : $booking->user->name }}</td>
                        <td class="live">
                            <a href="javascript:void(0)" data-recipient-id="{{ $booking->user_id }}"
                               data-toggle="modal" data-target="#send-message-modal" data-dismiss="modal"
                               data-lesson-id="{{ $lesson->id }}" class="la la-envelope message-user-btn"></a>
                        </td>
                        @if($lesson->max_num_bookings == 1 && $lesson->status == 'live')
                            <td class="live">
                                <a href="javascript:void(0)" class="la la-arrow-right move-class-modal-btn"
                                   data-toggle="modal" data-target="#move-class-modal" data-dismiss="modal"
                                   data-booking-id="{{ $booking->id }}" data-parent-id="{{ $booking->user_id }}"
                                   data-route="{{ route('educator.move.class.modal') }}"></a>
                            </td>
                        @endif
                    </tr>

                    <tr class="see-class">
                        <td colspan="{{ $lesson->max_num_bookings == 1 ? 3 : 2 }}" style="padding: 0">
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
                                            {{ \Carbon\Carbon::parse($bookingClass->class->end_time)->format('H:i') }})
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>

        </table>

    </div>
    <!-- end : table data -->

    <!-- Starts : action links -->
    <div class="action-links text-center">

        <table class="table buttons">
            <tr>
                @if($bookings->count())
                    <td>
                        <a href="{{ route('educator.message.class', $lesson->id) }}" class="btn btn-brand shadow-v4">
                            Message Class</a>
                    </td>
                @endif

                @if($lesson->status === 'live' && !$lesson->deleted_at)
                    <td class="">
                        <button type="button" class="btn btn-brand shadow-v4 pause-set-route-btn"
                                data-dismiss="modal" data-toggle="modal"
                                data-route="{{ route('educator.lesson.pause',$lesson->id) }}"
                                data-target="#pause-class-modal">Pause Class
                        </button>
                    </td>
                @endif

                @if($lesson->status === 'paused'  && !$lesson->deleted_at)
                    <td class="">
                        <button type="button" class="btn btn-secondary btn-text-red shadow-v4 live-set-route-btn"
                                data-dismiss="modal" data-toggle="modal"
                                data-route="{{ route('educator.lesson.live',$lesson->id) }}"
                                data-target="#live-class-modal"
                        >Set Class Live
                        </button>
                    </td>
                @endif

                @if($lesson->status === 'live' && !$lesson->bookings->count() && !$lesson->deleted_at)
                    <td class="">
                        <a href="{{ route('educator.lesson.edit', $lesson->id)  }}" type="button"
                           class="btn btn-secondary btn-text-red shadow-v4">Edit Class</a>
                    </td>
                @endif

                @if($lesson->status === 'expired' || $lesson->deleted_at)
                    <td class="">
                        <a href="{{ route('educator.lesson.edit', $lesson->id)  }}?restart" type="button"
                           class="btn btn-secondary btn-text-red shadow-v4">Restart Class</a>
                    </td>
                @endif

                @if($lesson->status === 'draft')
                    <td class="">
                        <a href="{{ route('educator.lesson.edit', $lesson->id)  }}" type="button"
                           class="btn btn-secondary btn-text-red shadow-v4">Finish/Complete Class</a>
                    </td>
                @endif
            </tr>
        </table>

        <table class="table links  m-0">
            <tr>
                @if($lesson->status === 'live' && !$lesson->deleted_at)
                    <td><a href="javascript:void(0)" class="cancel-set-route-btn" data-dismiss="modal"
                           data-toggle="modal" data-route="{{ route('educator.lesson.cancel',$lesson->id) }}"
                           data-target="#cancel-class-modal">Cancel Class</a></td>
                @endif

                @if($lesson->status === 'live' && !$lesson->deleted_at)
                    <td><a href="javascript:void(0)" class="delete-set-route-btn" data-dismiss="modal"
                           data-toggle="modal" data-route="{{ route('educator.lesson.trash',$lesson->id) }}"
                           data-target="#delete-class-modal">Delete Class</a></td>
                @endif
            </tr>
        </table>

    </div>
    <!-- end : action links -->

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


