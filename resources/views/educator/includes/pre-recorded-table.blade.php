<div class="classes-table dashboard-right-table">

    <div class="row title-add-button">
        <div class="col-md-9 col-sm-12">
            <h4 class="dashboard-header" style="display: inline"><a href="{{ route('educator.classes') }}">My
                    Classes</a></h4>
            <h4 class="dashboard-header" style="display: inline"><a href="{{ route('educator.subjects') }}">My
                    Subjects</a></h4>
            <h4 class="dashboard-header dashboard-header-active" style="display: inline">Pre-Recorded</h4>
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
                    <td colspan="3"> <h4 class="text-center mb-5">You have no Pre-Recorded Classes.</h4> </td>
                </tr>
            @else
                @foreach($lessons as $lesson)
                    <tr id="lesson-{{ $lesson->id }}">
                        <td>{{ $lesson->name }}</td>
                        <td class="{{ $lesson->status != 'live' ? 'cancelled' : 'live'}}">
                            {{ ucwords(str_replace('_', ' ', $lesson->status)) }}
                        </td>
                        <td>
                            {{--@if($lesson->status == 'live')--}}
                            <a href="javascript:void(0)" data-toggle="modal"
                               data-target="#visit-class-modal" class="visit-class-btn"
                               data-route="{{ route('pre-recorded.details.modal', $lesson->id) }}">
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
