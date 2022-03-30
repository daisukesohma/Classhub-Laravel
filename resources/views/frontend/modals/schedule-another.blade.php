<div class="row call-details">
    <div class="col-md-12">
            <span>You have a call scheduled with <strong>{{ \App\User::withTrashed()->find($scheduleWithRecipient->recipient_id)->name }}</strong>
                at {{ \Carbon\Carbon::parse($scheduleWithRecipient->video_call_time)->format('d/m/Y h:i A') }},
                This call is still booked and has not been affected, Do you want to schedule another?</span>

    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <button class="btn btn-primary" style="margin: 10px;" id="new-schedule-btn"
                data-dismiss="modal" data-toggle="modal" data-recipient-id="{{ $scheduleWithRecipient->recipient_id }}" data-target="#new-video-call-scheduler">Yes
        </button>
        <button class="btn btn-primary"
                style="margin: 10px; background-color: #fff !important; color:#000"
                data-dismiss="modal">No
        </button>
    </div>
</div>
