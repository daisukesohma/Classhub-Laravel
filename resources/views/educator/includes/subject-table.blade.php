<div class="classes-table dashboard-right-table">

    <div class="row title-add-button">
        <div class="col-md-9 col-sm-12">
            <h4 class="dashboard-header" style="display: inline"><a href="{{ route('educator.classes') }}">My
                    Classes</a></h4>
            <h4 class="dashboard-header dashboard-header-active" style="display: inline">My Subjects</h4>
            <h4 class="dashboard-header" style="display: inline"><a href="{{ route('educator.pre-recorded') }}">Pre-Recorded</a></h4>
        </div>
        <div class="col-md-3 col-sm-12 text-right add-class-button">
            <a href="{{ route('educator.inbox') }}" class="btn btn-brand">Create A Booking</a>
        </div>
    </div>

    <div class="m-scrollable" data-scrollable="true" data-max-height="420">

        <table class="table">

            <thead>
            <tr>
                <th>Class Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <!-- starts: list 01 -->
            @if( count($lessons) == 0 )
                <tr>
                    <td colspan="3"> You have no current bookings. <a href="{{ route('educator.inbox') }}">Create A
                            Booking</a></td>
                </tr>
            @else
                @foreach($lessons as $subjectId => $lessonSubjects)
                    @php
                        $status = $lessonSubjects->where('status', 'live')->count() ? 'live' : 'expired';
                    @endphp
                    <tr id="lesson-{{ $subjectId }}">
                        <td>{{ $lessonSubjects->first()->name }}</td>
                        <td class="{{ $status != 'live' ? 'cancelled' : 'live'}}">
                            {{ ucwords($status) }}
                        </td>
                        <td>
                            {{--@if($lesson->status == 'live')--}}
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#visit-class-modal" class="visit-class-btn"
                               data-route="{{ route('subject.details.modal', $subjectId) }}">
                                Visit Class</a>
                        </td>
                    </tr>
                    <!-- end: list 01 -->
                @endforeach
            @endif
            </tbody>

        </table>

    </div>
</div>

<!--begin::Modal-->
