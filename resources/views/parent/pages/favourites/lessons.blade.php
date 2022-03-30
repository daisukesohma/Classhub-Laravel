@extends('parent.layouts.master')


@section('title')
    Classhub | My Favourite Classes
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
                    <div class="title p-t-12">MY FAVOURITES CLASSES <i class="flaticon-black"></i></div>
                    @if($lessons->count())
                        <a href="javascript:;" class="link-select link-01">Select</a>
                        <a href="javascript:;" class="link-cancel link-01">Cancel</a>
                    @endif
                </div>
            </div>
            <!-- Starts: Tiles type 01 -->

            <!-- Starts: Tiles type 02 -->
            <div class="row tiles-type-01 fav-select checkbox-v1 show-select">
                @if( count($lessons) == 0 )
                    <div class="emptyState">
                        <h4 class="text-center p-t-60 p-b-60">You have no favourite classes</h4>
                    </div>
                @else
                    @foreach($lessons as $lesson)

                    <!-- starts : tile 01 -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="fav-{{ $lesson->id }}">
                            <div class="image-tile outer-title col-eq-height" style="padding-top: 0">

                                <!-- starts : fav + select -->
                                <div class="toggle-fav-select">
                                    <div class="fav"><i class="flaticon-black"></i></div>
                                    <div class="select">
                                        <label
                                            class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
                                            <input class="favourite" type="checkbox" name="favourites[]"
                                                   value="{{ $lesson->id }}"
                                                   data-unlike-route="{{ route('unlike.lesson', $lesson->id) }}"
                                                   data-share-route="{{ route('share.lesson', $lesson->id) }}"
                                                   data-fb-url="{{ \App\Setting::FACEBOOK_SHARE_URL.env('FACEBOOK_APP_ID').'&href='.
                                       urlencode(route('page.lesson', $lesson->slug)).'&display=page&redirect_uri='.urlencode(route('page.lesson', $lesson->slug)) }}"
                                                   data-msg-url="{{ $mobile ? \App\Setting::MESSENGER_MOBILE_BASE_URL.env('FACEBOOK_APP_ID')
                .'&link='.route('page.educator', $lesson->slug).'&redirect_uri='.route('page.lesson', $lesson->slug) : \App\Setting::MESSENGER_BASE_URL.env('FACEBOOK_APP_ID')
                .'&link='.route('page.educator', $lesson->slug).'&redirect_uri='.route('page.lesson', $lesson->slug) }}"
                                                   data-ws-url="{{ $mobile ? \App\Setting::WHATSAPP_MOBILE_SHARE_URL : \App\Setting::WHATSAPP_SHARE_URL }}{{ route('page.lesson', $lesson->slug) }}">

                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                <!-- end : fav + select -->

                                <a href="javascript:;">
                                    <img alt="Pic" class="product-thumb"
                                         src="{{ $lesson->images->count() ? Storage::url($lesson->images->first()->path)
                             : 'https://dummyimage.com/460x320/000/fff' }}"
                                         style="object-fit: cover; width: 100%; height: 190px"
                                    />
                                </a>

                                <div class="tile-details">
                                    <div class="location fw-4">
                                        {{ $lesson->location ? $lesson->location : $lesson->areas->first()->address }}
                                    </div>
                                    <div class="name fw-4">{{ $lesson->name }}</div>
                                    <div class="provideby">Provided by <b>{{ optional($lesson->user)->name }}</b></div>
                                    <!-- starts: Rating -->
                                @if(!$lesson->ratings()->isEmpty())

                                    @include('common.rating-v2',
                                        ['rating' => \App\Helpers\ClassHubHelper::ratings($lesson->ratings())])
                                @endif
                                <!-- end: Rating -->
                                    <!-- starts: price + button -->
                                    <div class="price">
                                        <!-- starts: button -->
                                        <a href="{{ route('page.lesson', $lesson->slug) }}" class="btn btn-primary">
                                            <span class="btn__text uppercase">book now</span>
                                        </a>
                                        <!-- end: button -->
                                        <div><strong><span>{{ $lesson->display_price }} </span></strong>
                                            {{ \App\Helpers\ClassHubHelper::lessonTypePriceText($lesson) }}
                                        </div>
                                    </div>
                                    <!-- end: price + button -->
                                </div>
                            </div>
                        </div>
                        <!-- end : tile 01 -->
                    @endforeach
                @endif
            </div>
            <!-- End: Tiles type 02 -->


        @if($lessons->count())
            <!-- starts: See my favourites -->
                <div class="container share-delete">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <a class="link-01 share-btn" href="javascript:void(0);"
                               data-toggle="modal" data-target="#share-lesson-modal">Share</a>
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

    @include('parent.modals.share-lesson')

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


            $('button.share-lesson-btn').on('click', function () {

                var checked = false;
                $('div#share-lesson-modal').modal('hide')
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
                                lesson_id: id
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
                    $(resultModal).find('div.modal-body').html('Please select Class')
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
    </script>
@endsection
