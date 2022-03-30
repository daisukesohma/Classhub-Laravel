@extends('admin.layouts.master')

@section('title')
    Classhub | Admin Dashboard
@endsection

@section('content')

    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">
                    Dashboard
                </h3>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <!--Begin::Section-->
        <!--begin:: Widgets/Stats-->
        <div class="row">
            <div class="col-xl-12">
                <!--begin:: Widgets/Blog-->
                <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force"
                     style="height: 300px;">
                    <div class="m-portlet__head m-portlet__head--fit-">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text m--font-light">
                                    Classhub Total Earnings
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                    m-dropdown-toggle="hover">
                                    <a href="#"
                                       class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill m-btn btn-outline-light m-btn--hover-light">
                                        All Time
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span
                                            class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" id="today-data"
                                                               class="m-nav__link earning-data"
                                                               data-total="{{ $earnings[0] }}">
                                                                <i class="m-nav__link-icon flaticon-graph"></i>
                                                                <span class="m-nav__section-text">
																				Today
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" id="week-data"
                                                               class="m-nav__link earning-data"
                                                               data-total="{{ $earnings[1] }}">
                                                                <i class="m-nav__link-icon flaticon-graph"></i>
                                                                <span class="m-nav__link-text">
																					This Week
																				</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" id="month-data"
                                                               class="m-nav__link earning-data"
                                                               data-total="{{ $earnings[2] }}">
                                                                <i class="m-nav__link-icon flaticon-graph"></i>
                                                                <span class="m-nav__link-text">
																					This Month
																				</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" id="year-data"
                                                               class="m-nav__link earning-data"
                                                               data-total="{{ $earnings[3] }}">
                                                                <i class="m-nav__link-icon flaticon-graph"></i>
                                                                <span class="m-nav__link-text">
																					This Year
																				</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" id="total-data"
                                                               class="m-nav__link earning-data"
                                                               data-total="{{ $earnings[4] }}">
                                                                <i class="m-nav__link-icon flaticon-graph"></i>
                                                                <span class="m-nav__link-text">
																					All Time
																				</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body" style="padding: 0">
                        <div class="m-widget27 m-portlet-fit--sides">
                            <div class="m-widget27__pic">
                                <canvas id="animated-lines" style="background-color: #e74b65 !important">

                                </canvas>
                                <h3 class="m-widget27__title m--font-light">
													<span id="earning-text">
                                                        <span style="font-size: 25px">Loading...</span>
													</span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Blog-->
            </div>
        </div>
        <!--end:: Widgets/Stats-->
        <!--begin:: Widgets/Stats-->
        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item" style="margin-bottom: 3em">
                                <h4 class="m-widget24__title">
                                    New Adverts
                                    <small>(today)</small>
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
												</span>
                                <span class="m-widget24__stats m--font-danger" style="float: none;">
                                    {{ $lessonCount[0] }}</span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    New Adverts
                                    <small>(this week)</small>
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
												</span>
                                <span class="m-widget24__stats m--font-danger" style="float: none;">
                                    {{ $lessonCount[1] }}</span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    New Adverts
                                    <small>(this month)</small>
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
												</span>
                                <span class="m-widget24__stats m--font-danger" style="float: none;">
                                    {{ $lessonCount[2] }}</span>
                                <div class="m--space-10"></div>
                            </div>
                        </div>
                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-12 col-lg-3 col-xl-3">
                        <!--begin::New Feedbacks-->
                        <a href="{{ route('admin.refunds') }}" style="text-decoration: none;">
                            <div class="m-widget24">
                                <div class="m-widget24__item">
                                    <h4 class="m-widget24__title">
                                        Refund Requests
                                    </h4>
                                    <br>
                                    <span class="m-widget24__desc">
													</span>
                                    <span class="m-widget24__stats m--font-danger" style="float: none;">
														{{ $refundRequestNum }}
													</span>
                                    <div class="m--space-10"></div>
                                </div>
                            </div>
                        </a>
                        <!--end::New Feedbacks-->
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Widgets/Stats-->
        <div class="row">
            <div class="col-xl-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Newest Adverts
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('admin.lessons') }}"
                                       class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
														<span>
															<span>
																View All
															</span>
														</span>
                                    </a>
                                </li>
                                <li class="m-portlet__nav-item"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Datatable -->
                        <div class="m-section">
                            <div class="m-section__content">
                                <table class="table m-table m-table--head-bg-brand">
                                    <thead>
                                    <tr>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Supplier
                                        </th>
                                        <th>
                                            Category
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lessons as $lesson)
                                        <tr>
                                            <th scope="row" id="{{ $lesson->id }}">
                                                {{ \Carbon\Carbon::parse($lesson->created_at)->format('d/m/Y') }}
                                            </th>
                                            <th>
                                                {{ $lesson->name }}
                                            </th>
                                            <td>
                                                {{ $lesson->user->name }}
                                            </td>
                                            <td>
                                                {{ \App\Category::getDisplayName($lesson->category->id) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('page.lesson', $lesson->slug) }}" target="_blank"
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                                                    m-btn--icon-only m-btn--pill"
                                                   title="View">
                                                    <i class="la la-eye"></i>
                                                </a>
                                                @if($result = $lesson->canPauseOrLive())
                                                    <a href="javascript:;"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                                                       m-btn--icon-only m-btn--pill update-status"
                                                       data-route="{{ route('lesson.update.status', $lesson->id) }}"
                                                       title="{{ $result[0] }} Advert">
                                                        <i class="la la-{{ $result[1] }}"></i>
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Reported Adverts
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">
                                    <a href="{{ route('admin.reported.lessons') }}"
                                       class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
														<span>
															<span>
																View All
															</span>
														</span>
                                    </a>
                                </li>
                                <li class="m-portlet__nav-item"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <!--begin: Datatable -->
                        <div class="m-section">
                            <div class="m-section__content">
                                <table class="table m-table m-table--head-bg-brand">
                                    <thead>
                                    <tr>
                                        <th>
                                            Title
                                        </th>
                                        <th>
                                            Supplier
                                        </th>
                                        <th>
                                            Report
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reportedLessons as $reportedLesson)

                                        <tr>
                                            <th>
                                                {{ $reportedLesson->lesson->name }}
                                            </th>
                                            <td>
                                                {{ $reportedLesson->lesson->user->name }}
                                            </td>
                                            <td>
                                                {{ $reportedLesson->reason }}
                                            </td>
                                            <td>
                                                <a href="{{ route('page.lesson', $reportedLesson->lesson->slug) }}"
                                                   class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                                                    m-btn--icon-only m-btn--pill" target="_blank"
                                                   title="View">
                                                    <i class="la la-eye"></i>
                                                </a>
                                                @if($result = $reportedLesson->lesson->canPauseOrLive())
                                                    <a href="javascript:;"
                                                       class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon
                                                       m-btn--icon-only m-btn--pill update-status"
                                                       data-route="{{ route('lesson.update.status', $reportedLesson->lesson_id) }}"
                                                       title="{{ $result[0] }} Advert">
                                                        <i class="la la-{{ $result[1] }}"></i>
                                                    </a>
                                                @endif
                                                @if($reportedLesson->lesson->canCancel())
                                                    <a href="javascript:;" class="m-portlet__nav-link btn m-btn m-btn--hover-brand
                                                        m-btn--icon m-btn--icon-only m-btn--pill cancel-lesson"
                                                       title="Close Advert"
                                                       data-route="{{ route('lesson.update.status', $reportedLesson->lesson_id) }}">
                                                        <i class="la la-close"></i></a>
                                                @else
                                                    <span
                                                        class="m-badge  m-badge--danger m-badge--wide">Cancelled</span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('page_scripts')
    <script src="{{ asset('admin/js/dashboard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/animated-lines.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {

            $('a.earning-data').on('click', function () {
                let total = $(this).data('total');
                $('span#earning-text').html(`<span>€</span>${new Intl.NumberFormat('ie-IE').format(total)}`);
            })

            $.ajax({
                type: 'GET',
                url: '{{ route('admin.get.earnings') }}',
                data: {_token: '{{ csrf_token() }}'},
                dataType: 'JSON',
                success: function (data) {
                    if (data.status) {
                        console.log(data.earnings)
                        $('span#earning-text').html(`<span>€</span>${new Intl.NumberFormat('ie-IE').format(data.earnings[4])}`);
                        $('a#today-data').attr('data-total', data.earnings[0])
                        $('a#week-data').attr('data-total', data.earnings[1])
                        $('a#month-data').attr('data-total', data.earnings[2])
                        $('a#year-data').attr('data-total', data.earnings[3])
                        $('a#total-data').attr('data-total', data.earnings[4])
                    }
                },
                error: function (data) {
                    console.log(data)
                }
            })

            // Pause/Unpaused Class
            $('body').on('click', 'a.update-status', function () {
                var status = $(this).children('i').hasClass('la-pause') ? 'paused' : 'live'
                var _this = $(this)

                swal({
                    title: `Are you sure you want to ${status} this Advert?`,
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: `Yes, ${status}`,
                    cancelButtonText: "No, cancel",
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            $.ajax({
                                type: 'POST',
                                url: $(_this).data('route'),
                                data: {_token: '{{ csrf_token() }}', 'status': status},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        if ($(_this).children('i').hasClass('la-pause')) {
                                            $(_this).attr('title', 'Unpaused Advert')
                                            $(_this).children('i').removeClass('la-pause').addClass('la-play')
                                        } else {
                                            $(_this).attr('title', 'Pause Advert')
                                            $(_this).children('i').removeClass('la-play').addClass('la-pause')
                                        }
                                        swal(`Success`, data.messages.join(), "success")
                                    } else {
                                        swal(`Error`, data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal(`Error`, data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })


            // Cancel Clas
            $('body').on('click', 'a.cancel-lesson', function () {
                var status = 'cancelled'
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to close this Advert, This action is Irreversible?',
                    type: 'error',
                    showCancelButton: !0,
                    confirmButtonText: `Yes, close`,
                    cancelButtonText: "No, cancel",
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            $.ajax({
                                type: 'POST',
                                url: $(_this).data('route'),
                                data: {_token: '{{ csrf_token() }}', 'status': status},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        $(_this).siblings('a.update-status').remove()
                                        $(_this).remove()
                                        swal(`Advert Closed`, data.messages.join(), "success")
                                    } else {
                                        swal(`Error`, data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal(`Error`, data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })


        })
    </script>
@endsection
