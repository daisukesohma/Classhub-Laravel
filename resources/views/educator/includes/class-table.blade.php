<div class="classes-table dashboard-right-table">

    <div class="row title-add-button">
        <div class="col-md-9 col-sm-12">
            <h4 class="dashboard-header dashboard-header-active" style="display: inline">My Classes</h4>
            <h4 class="dashboard-header" style="display: inline"><a href="{{ route('educator.subjects') }}">My Subjects</a></h4>
            <h4 class="dashboard-header" style="display: inline"><a href="{{ route('educator.pre-recorded') }}">Pre-Recorded</a></h4>
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
                    <td colspan="3">You have no classes listed. </td>
                </tr>
            @else
                @foreach($lessons as $lesson)
                    <tr id="lesson-{{ $lesson->id }}">
                        <td>{{ $lesson->name }}</td>
                        <td class="{{ $lesson->deleted_at || $lesson->status == 'expired' ? 'cancelled' : $lesson->status }}">
                            @if($lesson->deleted_at)
                                {{ 'Deleted' }}
                            @elseif($lesson->status == 'draft')
                                {{ 'Unfinished' }}
                            @else
                                {{ ucwords($lesson->status) }}
                            @endif
                        </td>
                        <td>
                            {{--@if($lesson->status == 'live')--}}
                                <a href="javascript:void(0)" data-toggle="modal"
                                   data-target="#visit-class-modal" class="visit-class-btn"
                                   data-route="{{ route('lesson.details.modal', $lesson->id) }}">
                                    Visit Class</a>
                            {{--@elseif($lesson->status == 'paused')
                                <a href="javascript:void(0)" data-toggle="modal"
                                   data-target="#visit-class-modal" class="visit-class-btn"
                                   data-route="{{ route('lesson.details.modal', $lesson->id) }}">
                                    Live Class</a>
                            @elseif(in_array($lesson->status, ['expired', 'cancelled']) )
                                <a href="{{ route('educator.lesson.edit', $lesson->id)  }}?restart">Restart Class</a>
                            @elseif( $lesson->status == 'draft')
                                <a href="{{ route('educator.lesson.edit', $lesson->id)  }}">Finish Class</a>
                            @endif--}}
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
<div class="modal fade c-modal visit-class" id="visit-class-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
