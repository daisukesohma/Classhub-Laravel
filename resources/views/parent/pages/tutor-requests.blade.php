@extends('parent.layouts.master')


@section('title')
    Classhub | Tutor Requests
@endsection


@section('page_styles')
    <style type="text/css">
        .delete-draft {
            border: 1px solid;
            border-radius: 18px;
            padding: 0 5px;
            cursor: pointer;
            background-color: transparent !important;
        }

        .copy-link:hover {
            border: none !important;
            background: none !important;
        }

        @media (min-width: 1200px) {
            .m-body .m-content {
                padding: 30px 0px !important;
            }
        }

        .job-viewed {
            background: transparent !important;
            color: #E74B65 !important;
        }

        .jscroll-inner {
            width: 100%;
        }

        a.job-viewed:hover {
            text-decoration: none !important;
            color: #E74B65 !important;
        }

        .job-board-link {
            position: relative;
        }

        .m-menu__link-badge {
            position: absolute;
            right: -10px;
            top: -10px;
        }

        .m-menu__link-badge .m-badge {
            color: #ffffff;
            background: #e74b65;
            border: 1px solid #333333;
        }

        .next-page {
            float: right;
        }

        .prev-page {
            float: left;
        }

        a.delete-btn, a.delete-all {
            padding-top: 5px !important;
            padding-bottom: 5px !important;
        }

        .profile-image-lesson {
            width: 110px !important;
            height: 110px !important;
        }
    </style>
@endsection

@section('content')

    <!-- redirect to first page if no requests and page param exist  -->
    @if(!$groupTutorRequests->count() && request()->get('page'))
        <script type="text/javascript">
            window.location = '{{ route('parent.tutor.requests') }}'
        </script>
    @endif

    <!-- starts : main container -->
    <div class="main-container" style="padding-top: 30px">

        <div class="container settings-form list-a-class">
            <div class="row">
                <div class="col-xs-12 padding-mobile-none-lr">

                    <div class="title fs-30 fw-5 p-t-15 p-b-25 p-l-0">Tutor Requests</div>

                    <!-- starts: account settings -->
                    <div class="m-portlet">
                        <div class="m-wizard__form">
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">
                                <!--begin: Form Wizard Step 1-->
                                <div class="row">
                                    <div class="col-md-12 padding-mobile-none-lr">
                                        <div class="m-form__section m-form__section--first">

                                            <div class="row show-more-jobs-container" id="tutor-requests">
                                                @if($groupTutorRequests->count())
                                                    <div class=" delete-all row"
                                                        id="subject-tutors-more-link">
                                                        <div class="col-sm-12 col-12 text-center">
                                                            <a class="btn btn-primary shadow-v4 show-more-jobs-button delete-all"
                                                               href="javascript:;">
                                                                <span class="btn__text">DELETE ALL</span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    @foreach($groupTutorRequests as $key => $groupTutorRequest)
                                                        @if($key)
                                                            <?php $tutorRequest = $groupTutorRequest[0];?>
                                                            <div class="col-md-12 tutor-request-row" id="tutor-request-{{ $key }}">
                                                                <div class="m-portlet job-card">
                                                                    <div class="m-portlet__body" style="padding: 10px">
                                                                        <div class="row">
                                                                            <div class="col-md-8 col-lg-9 text-center-xs p-l-35">
                                                                                <h4>{{ \App\Helpers\ClassHubHelper::getSubjectDisplayName(\App\Category::find($tutorRequest->subject_id),
                                                                                    \App\Category::all()) }}</h4>
                                                                                @if(@unserialize($tutorRequest->detail))
                                                                                    <span>
                                                                                        {{ @unserialize($tutorRequest->detail)['location'] }}
                                                                                        | {{ @unserialize($tutorRequest->detail)['preference'] }}
                                                                                        | {{ \Carbon\Carbon::parse($tutorRequest->created_at)->format('d/m/Y H:i A ') }}
                                                                                    </span><br><br>
                                                                                @endif
                                                                                <p>{{ $tutorRequest->message  }}</p>
                                                                            </div>
                                                                            <div
                                                                                class="col-md-3 col-lg-3 text-center job-action">
                                                                                <div
                                                                                    style="display:table; width: 100%; height: 100%">
                                                                                    <div style="display:table-cell;vertical-align:middle;">
                                                                                        <a class="btn btn-primary text-center uppercase delete-btn"
                                                                                            href="javascript:;"
                                                                                            data-id="{{ $key }}"
                                                                                            style="width: 100%;">
                                                                                            Delete
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                @else
                                                    <div class="col-md-12 no-jobs-block">
                                                        <h4 style="text-align: center">No Tutor requests</h4>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end : main container -->

@endsection

@section('page_scripts')
    {{--<script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/show-more-jobs.js') }}"></script>--}}
    <script type="text/javascript">

        $(function () {
            $('body').on('click', 'a.delete-btn', function () {
                var groupId = $(this).data('id')

                console.log(groupId)

                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('parent.tutor-request.delete') }}',
                    data: {
                        group_id: groupId,
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $(`div#tutor-request-${groupId}`).remove()
                            if (!$('.tutor-request-row').length) {
                                $(`div#tutor-requests`).html(`
                                    <div class="col-md-12 no-jobs-block">
                                        <h4 style="text-align: center">No Tutor requests</h4>
                                    </div>
                                `)
                            }
                            $(resultModal).modal('hide')

                            //$(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).modal('show')
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        console.log(data)
                        //$(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
            })

            $('body').on('click', 'a.delete-all', function () {

                $(resultModal).modal('show')

                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('parent.tutor-request.delete-all') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $(`div#tutor-requests`).html(`
                                <div class="col-md-12 no-jobs-block">
                                    <h4 style="text-align: center">No Tutor requests</h4>
                                </div>
                            `)
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        } else {
                            $(resultModal).modal('show')
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
@endsection
