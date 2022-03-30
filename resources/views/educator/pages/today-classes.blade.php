@extends('educator.layouts.master')

@section('title')
    Classhub | Educator Dashboard
@endsection


@section('page_style')
    <style>

        .copy-link:hover {
            border: none !important;
            background: none !important;
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
                                <h3 class="m-form__heading-title" style="padding-bottom: 20px">Your Tutor Dashboard</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-lg-4 padding-mobile-none-lr col-eq-height">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6 col-xs-ps-0">
                                        <!-- starts : Dashboard Nav  -->
                                        <div class="profile-side-nav">
                                            <div class="m-portlet">
                                                <div class="m-portlet__body">

                                                    @include('educator.includes.left-menu', ['page' => 'today-classes'])

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @if(!Auth::user()->trusted)
                                        <div class="col-lg-12 col-md-6 col-md-eq-height col-xs-ps-0">
                                            <!-- starts : Trusted Section  -->
                                            <div class="profile-side-nav">
                                                <div class="m-portlet trusted-box">
                                                    <div class="m-portlet__body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-3 col-xs-3">
                                                                <img class="trusted-shield"
                                                                     src="/img/trusted-by/list-a-class/batch.png"/>
                                                            </div>
                                                            <div class="col-md-8 col-sm-9 col-xs-9">
                                                                <h4>Become Trusted</h4>
                                                                <span class="subtitle">Click <a
                                                                        href="{{ route('educator.trusted') }}">here</a> to learn more</span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                            </div>
                                            <!-- end : Trusted Section  -->
                                            <!-- end : Dashboard Nav -->
                                        </div>
                                    @endif
                                </div>

                            </div>
                            <div class="col-xl-9 col-lg-8 padding-mobile-none-lr col-eq-height">

                                <!--starts: classes Table -->
                                <div class="classes-table dashboard-right-table">

                                    <div class="row title-add-button">
                                        <div class="col-md-9 col-sm-12">
                                            <h4 class="dashboard-header" style="display: inline"><a href="#">Today
                                                    Classes</a></h4>
                                        </div>
                                    </div>

                                    <div class="m-scrollable" data-scrollable="true" data-max-height="420">

                                        <table class="table">

                                            <thead>
                                            <tr>
                                                <th>Class Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <!-- starts: list 01 -->
                                            @if( count($classes) == 0 )
                                                <tr>
                                                    <td colspan="3"><h4 class="text-center mb-5">You have no class
                                                            Today.</h4>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach($classes as $class)
                                                    <tr id="class-{{ $class->id }}">
                                                        <td>{{ $class->lesson->name }}
                                                            ({{\Carbon\Carbon::parse($class->start_time)->format('g:i A')}}
                                                            - {{\Carbon\Carbon::parse($class->end_time)->format('g:i A')}}
                                                            )
                                                        </td>
                                                        <td>
                                                        <a 
                                                            @if( $class->meeting_link )
                                                                href="{{ $class->meeting_link }}"
                                                                target="_blank"
                                                            @else
                                                                href="{{ route('page.video-call', $class->id) }}"
                                                            @endif
                                                            class="visit-class-btn">
                                                            Join Video Call
                                                        </a>
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

                                <!--end: classes Table -->
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>




@endsection

@section('page_scripts')


@endsection
