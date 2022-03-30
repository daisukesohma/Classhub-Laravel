@extends('parent.layouts.master')


@section('title')
    Classhub | Account Settings
@endsection


@section('page_styles')
    <style type="text/css">
        span.card-brand {
            padding: 2px 4px;
            background-color: #000;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            border: none;
            vertical-align: middle;
        }
    </style>
@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container" style="padding-top: 30px">

        <div class="container settings-form list-a-class">
            <div class="row">
                <div class="col-xs-12 padding-mobile-none-lr">

                    <div class="title fs-30 fw-5 p-t-15 p-b-25 p-l-0">Today's Classeses</div>

                    <!-- starts: account settings -->
                    <div class="m-portlet">
                        <div class="m-wizard__form">
                            <!--begin: Form Body -->
                            <div class="m-portlet__body">
                                <!--begin: Form Wizard Step 1-->
                                <div class="row">
                                    <div class="col-md-12 padding-mobile-none-lr">
                                        <div class="m-form__section m-form__section--first">

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

@endsection
