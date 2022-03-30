@extends('educator.layouts.master')

@section('title')
    Classhub | Stats Report
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
                    <div class="m-content page-dashboard stats-report list-a-class initial-dash">

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

                                                    @include('educator.includes.left-menu', ['page' => 'my-stats'])

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{--@if(!Auth::user()->trusted)
                                    <div class="col-lg-12 col-md-6 col-md-eq-height col-xs-ps-0">
                                      <!-- starts : Trusted Section  -->
                                      <div class="profile-side-nav">
                                          <div class="m-portlet trusted-box">
                                              <div class="m-portlet__body">
                                                <div class="row">
                                                  <div class="col-md-4 col-sm-3 col-xs-3">
                                                    <img class="trusted-shield" src="/img/trusted-by/list-a-class/batch.png" />
                                                  </div>
                                                  <div class="col-md-8 col-sm-9 col-xs-9">
                                                    <h4>Become Trusted</h4>
                                                    <span class="subtitle">Click <a href="{{ route('educator.trusted') }}">here</a> to learn more</span>
                                                  </div>
                                                </div>


                                              </div>
                                          </div>

                                      </div>
                                      <!-- end : Trusted Section  -->
                                      <!-- end : Dashboard Nav -->
                                    </div>
                                    @endif--}}
                                </div>

                            </div>
                            <div class="col-xl-9 col-lg-8 padding-mobile-none-lr col-eq-height">
                                <div class="classes-table dashboard-right-table">
                                    <div class="row title-share">
                                        <div class="col-xl-6">
                                            <h4 class="dashboard-header">My Stats</h4>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="m-typeahead" style="margin-top:10px ">
                                                {!! Form::select('month', $months , null, [ 'required' => 'required', 'id' => 'monthly-stat',
                                                   'class' => 'stat-month-select form-control form-control--fixed m-bootstrap-select m_selectpicker']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- starts : lists -->
                                    <div class="lists row" id="educator-stats">

                                    </div>
                                    <!-- end : lists -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('educator.modals.share-profile')
@endsection

@section('page_scripts')
    <script src="{{ asset('educator/assets/js/bootstrap-select.js') }}" type="text/javascript"></script>


    <script type="text/javascript">

        $(function () {
            getStats('{{ \Carbon\Carbon::now()->format('Y-m') }}')

            $('select#monthly-stat').on('change', function () {
                getStats($(this).val())
            })
        })

        function getStats(date) {
            $.ajax({
                type: 'GET',
                url: '{{ route('educator.stats-all') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    date: date,
                },
                dataType: 'html',
                success: function (data) {
                    $('div#educator-stats').html(data)
                },
                error: function (data) {
                    $('div#educator-stats').html(data)
                }
            })
        }

        $('button.share-profile-btn').on('click', function () {
            $('div#share-profile-modal').modal('hide')
            $(resultModal).modal('show')
            var id = $(this).data('id')
            var route = $(this).data('share-route')

            $.ajax({
                type: 'POST',
                url: route,
                data: {
                    _token: '{{ csrf_token() }}',
                    share_email: $('input[name="share_email"]').val(),
                    educator_id: id
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    } else {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                },
                error: function (data) {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            })
        })
    </script>

@endsection
