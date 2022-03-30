<!-- starts : titles -->
<div class="title">Class Details</div>
<div class="sub-title">
    <span id="className">{{ $lesson->name }}</span> -
    <span class="participants"><span
            id="count">{{ $bookings->count() }}</span> Sales</span>
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
            </tr>
            </thead>

            <tbody>

            <!-- starts: list 01 -->
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->student_name ? $booking->student_name : $booking->user->name }}</td>
                    <td class="live">
                        <a href="javascript:void(0)" data-recipient-id="{{ $booking->user_id }}"
                           data-toggle="modal" data-target="#send-message-modal" data-dismiss="modal"
                           data-lesson-id="{{ $lesson->id }}" class="la la-envelope message-user-btn"></a>
                    </td>
                </tr>
            @endforeach
            </tbody>

        </table>

    </div>
    <!-- end : table data -->

    <div class="action-links text-center">

        <table class="table buttons">
            <tr>
                @if(!$bookings->count())
                    <a href="javascript:void(0)" class="delete-set-route-btn" data-dismiss="modal"
                       data-toggle="modal" data-route="{{ route('educator.lesson.trash',$lesson->id) }}"
                       data-target="#delete-class-modal">Delete Class</a>
                @endif
            </tr>
        </table>

    </div>


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
