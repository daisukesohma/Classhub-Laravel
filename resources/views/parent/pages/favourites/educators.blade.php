@extends('parent.layouts.master')


@section('title')
    Classhub | My Favourite Tutors
@endsection


@section('page_style')

@endsection

@section('content')

    <!-- starts : main container -->
    <div class="main-container display-table footer-stay-btm" style="padding-top: 30px"> {{----}}

        <!-- starts: fav-tutors tiles container -->
        <div class="container fav-classes">


            <!-- Starts: Tiles type 01 -->
            <div class="row title-type-01 fav-select-links show-link-select">
                <div class="col-sm-12">
                    <div class="title p-t-12">MY FAVOURITES TUTORS <i class="flaticon-black"></i></div>
                    @if($educators->count())
                        <a href="javascript:;" class="link-select link-01">Select</a>
                        <a href="javascript:;" class="link-cancel link-01">Cancel</a>
                    @endif
                </div>
            </div>
            <!-- Starts: Tiles type 01 -->

            <!-- Starts: Tiles type 02 -->
            <div class="row tiles-type-02 fav-select checkbox-v1 show-select">
                @if( count($educators) == 0 )
                    <div class="emptyState">
                        <h4 class="text-center p-t-60 p-b-60">You have no favourite tutors</h4>
                    </div>
                @else
                    @foreach($educators as $educator)

                        <div class="col-lg-3 col-md-4 col-sm-6" id="fav-{{ $educator->id }}">
                            <div class="image-tile  col-eq-height {{ $educator->trusted ? 'trusted' : '' }}">

                                <!-- starts : fav + select -->
                                <div class="toggle-fav-select">
                                    <div class="fav"><i class="flaticon-black"></i></div>
                                    <div class="select">
                                        <label
                                            class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
                                            <input class="favourite" type="checkbox" name="favourites[]"
                                                   value="{{ $educator->id }}"
                                                   data-unlike-route="{{ route('unlike.educator', $educator->id) }}"
                                                   data-share-route="{{ route('share.educator', $educator->id) }}"
                                                   data-fb-url="{{ \App\Setting::FACEBOOK_SHARE_URL.env('FACEBOOK_APP_ID').'&href='.
                                       urlencode(route('page.educator', $educator->slug)).'&display=page&redirect_uri='.
                                       urlencode(route('page.educator', $educator->slug))  }}"
                                                   data-msg-url="{{ $mobile ? \App\Setting::MESSENGER_MOBILE_BASE_URL.env('FACEBOOK_APP_ID')
            .'&link='.route('page.educator', $educator->slug).'&redirect_uri='.route('page.educator', $educator->slug) :  \App\Setting::MESSENGER_BASE_URL.env('FACEBOOK_APP_ID')
            .'&link='.route('page.educator', $educator->slug).'&redirect_uri='.route('page.educator', $educator->slug) }}"
                                                   data-ws-url="{{ $mobile ? \App\Setting::WHATSAPP_MOBILE_SHARE_URL : \App\Setting::WHATSAPP_SHARE_URL }}{{ route('page.educator', $educator->slug) }}">
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <!-- end : fav + select -->
                                <div class="profile-image-lesson"
                                     style="background-image: url({{ \App\Helpers\ClassHubHelper::getImagePath(null, $educator->educator->photo) }});">
                                </div>
                                <div class="tile-details tutor-details">
                                    <div class="name">{{ $educator->name }}</div>
                                    <div class="tutor-subjects color-02">
                                        {{ implode(', ', $educator->categories()->whereNull('parent_id')->pluck('name')->toArray()) }}
                                    </div>
                                    <!-- starts: Rating -->
                                @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($educator->ratings)])
                                <!-- end: Rating -->
                                    <div class="text text-center fs-13 tutor-description">
                                        {{ \App\Helpers\ClassHubHelper::excerpt($educator->bio, 10, false, false) }}
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <h5 class="detail-title">Classes:</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <span
                                                class="detail-result">{{ $educator->lessons()->liveClass()->count()  }}</span>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <h5 class="detail-title">Base Price:</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <span class="detail-result">€{{ $educator->base_price }} p/hr</span>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section">
                                            <h5 class="detail-title">Location:</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 details-section" style="height: 60px;">
                                            <span class="detail-result">{{ $educator->locations}}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    @endforeach
                @endif
            </div>
            <!-- End: Tiles type 02 -->


        @if($educators->count())
            <!-- starts: See my favourites -->
                <div class="container share-delete">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a class="link-01 share-btn" href="javascript:void(0);"
                               data-toggle="modal" data-target="#share-profile-modal">Share</a>
                            <a class="link-01 p-l-48 unlike-btn" href="javascript:void(0);">Delete</a>
                        </div>
                    </div>
                </div>
                <!-- end: See my favourites -->
            @endif

        </div>
        <!-- End:  fav-tutors tiles container -->


    </div>
    <!-- end : main container -->

    @include('parent.modals.share-profile')

@endsection

@section('page_scripts')
    <script type="text/javascript" src="{{ asset('parent/js/custom.js') }}"></script>

    <script type="text/javascript">
        $(function () {

            $('.link-select').on('click', function () {
                $('input.favourite').each(function () {
                    $(this).prop('checked', true)
                })
                $('.link-select').hide()
                $('.link-cancel').show()
            })

            $('.link-cancel').on('click', function () {
                $('input.favourite').each(function () {
                    $(this).prop('checked', false)
                })
                $('.link-cancel').hide()
                $('.link-select').show()
            })

            $('a.unlike-btn').on('click', function () {
                $('input[type="checkbox"]').each(function () {
                    if ($(this).is(':checked')) {
                        var id = $(this).val()
                        var route = $(this).data('unlike-route')

                        $.ajax({
                            type: 'POST',
                            url: route,
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            dataType: 'json',
                            success: function (data) {
                                console.log(data)
                                if (data.status) {
                                    $(`div#fav-${id}`).remove()
                                    window.location = '{{ route('parent.favourites') }}'
                                } else {

                                }
                            },
                            error: function (data) {
                            }
                        })
                    }
                })
            })

            $('button.share-profile-btn').on('click', function () {

                var checked = false;
                $('div#share-profile-modal').modal('hide')
                $(resultModal).modal('show')

                $('div.fav-select input[type="checkbox"]').each(function () {
                    if ($(this).is(':checked')) {
                        $(resultModal).find('div.modal-body').html('')

                        checked = true;
                        var id = $(this).val()
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
                                    $(resultModal).find('div.modal-body').append(data.messages.join('<br>'))
                                } else {
                                    $(resultModal).find('div.modal-body').append(data.messages.join('<br>'))
                                }
                            },
                            error: function (data) {
                                $(resultModal).find('div.modal-body').append(data.messages.join('<br>'))
                            }
                        })
                    }
                })

                if (!checked) {
                    $(resultModal).find('div.modal-body').html('Please select Tutor')
                }
            })


            $('a.share-social-btn').on('click', function () {
                var selectCount = 0;
                var fbUrl = '';
                var msgUrl = '';
                var wsUrl = '';
                $('div.fav-select input[type="checkbox"]').each(function () {
                    if ($(this).is(':checked')) {
                        selectCount++
                        fbUrl = $(this).data('fb-url')
                        msgUrl = $(this).data('msg-url')
                        wsUrl = $(this).data('ws-url')
                    }
                })

                if (selectCount == 1) {
                    var type = $(this).data('type')
                    if (type == 'facebook') {
                        window.open(fbUrl, '_blank')
                    }
                    if (type == 'messenger') {
                        window.open(msgUrl, '_blank')
                    }
                    if (type == 'whatsapp') {
                        window.open(wsUrl, '_blank')
                    }
                } else {
                    $(resultModal).find('div.modal-body').html('Please select one Class to share')
                    $(resultModal).modal('show')
                }
            })


        })

         $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        $("html").on("mouseup", function (e) {
            var l = $(e.target);
            if (l[0].className.indexOf("popover") == -1) {
                $(".popover").each(function () {
                    $(this).popover("hide");
                });
            }
        });

    </script>
@endsection
