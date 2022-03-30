@extends('educator.layouts.master')

@section('title')
    Classhub | Educator Dashboard
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
    </style>

@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper m-b-6">

            <div class="row col-12" style="margin-left:0px; margin-right:0px">

                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 auto;">
                    <div class="m-content page-dashboard initial-dash">

                        <div class="row title-share">
                            <div class="col-xl-6 col-lg-7 col-md-6 col-sm-12">
                                <h3 class="m-form__heading-title" style="padding-bottom: 20px">Jobs Board</h3>
                            </div>
                        </div>
                        <div class="row show-more-jobs-container">
                            @if($jobsBoard->count())
                                @foreach($jobsBoard as $jobBoard)
                                    @if(!\App\User::withTrashed()->find($jobBoard->parent_id)->deleted_at)
                                        <div class="col-md-12">
                                            <div class="m-portlet job-card">
                                                <div class="m-portlet__body">
                                                    <div class="row">
                                                        <div class="col-md-3 col-lg-2">
                                                            <div class="profile-image">
                                                                <img
                                                                    src="{{ \App\Helpers\ClassHubHelper::getImagePath(null,
                                                                 \App\Category::find($jobBoard->subject_id)->getParent()->banner) }}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5 col-lg-7 text-center-xs">
                                                            <h3>{{ \App\User::find($jobBoard->parent_id)->name }}</h3>
                                                            <span class="bold">
                                                            {{ \App\Helpers\ClassHubHelper::getSubjectDisplayName(\App\Category::find($jobBoard->subject_id),
                                                            \App\Category::all()) }}
                                                        </span><br><br>
                                                            @if(@unserialize($jobBoard->detail))
                                                                <span>
                                                            {{ @unserialize($jobBoard->detail)['location'] }}
                                                                    | {{ @unserialize($jobBoard->detail)['preference'] }}
                                                                    | {{ \Carbon\Carbon::parse($jobBoard->created_at)->format('d/m/Y H:i A ') }}
                                                        </span><br><br>
                                                            @endif
                                                            <p>{{ $jobBoard->message  }}</p>
                                                        </div>
                                                        <div class="col-md-4 col-lg-3 text-center job-action">
                                                            <div style="display:table; width: 100%; height: 100%">
                                                                <div style="display:table-cell;vertical-align:middle;">
                                                                    <a class="btn btn-primary text-center uppercase {{ $jobBoard->applied ? 'job-viewed' : '' }}"
                                                                       href="{{ route('educator.inbox', [null, 'jobboard_id='.$jobBoard->id]) }}"
                                                                       style="width: 100%; {{ $jobBoard->applied? 'background: transparent !important; color: #E74B65 !important; border-color:#E74B65 !important': ''  }}">{{ $jobBoard->applied ? 'Viewed' : 'Reply to this job request' }}
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

                                @if($jobsBoard->nextPageUrl())
                                    <div class="row showmore p-t-55 show-more-jobs-button-container"
                                         id="subject-tutors-more-link">
                                        <div class="col-sm-12 text-center">
                                            <a class="btn btn-primary shadow-v4 show-more-jobs-button"
                                               href="{{ $jobsBoard->nextPageUrl() }}">
                                                <span class="btn__text">SHOW MORE</span>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                            @else
                                <div class="col-md-12 no-jobs-block"
                                     style="background-image:url('/img/no-jobs-message.jpg') ">

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('page_scripts')
    <script src="{{ asset('js/jquery.jscroll.min.js') }}"></script>
    <script src="{{ asset('js/show-more-jobs.js') }}"></script>

@endsection
