<!--begin:: step2-category-not-into-profile Modal-->
<div class="modal fade c-modal overlay-share-this" id="share-profile-modal" tabindex="-1" role="dialog"
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

            <div class="modal-body ">
                <div class="overlay-share-content list-a-class">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group p-t-0">
                                <label class="fw-3" for="email">Share by email <span class="info-badge m-l-14"
                                                                                     data-toggle="m-popover"
                                                                                     data-html="true"
                                                                                     data-placement="bottom"
                                                                                     data-content="Add in the person's email that you want to share this with">i</span></label>
                                <input type="email" class="form-control" id="email" name="share_email" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-right" style="padding-top: 30px;">
                                <button type="button" data-id="{{ Auth::user()->id }}"
                                        data-share-route="{{ route('share.educator', Auth::user()->id) }}"
                                        class="btn btn-sm btn-primary shadow-v3 m-b-20 share-profile-btn">
                                    <span class="btn__text">Send</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="or m-b-14"><span><i>or</i></span></div>

                    <!-- starts: or, with other social media options -->
                    <div class="socailmedia-share">
                        <ul class="list">
                            @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
                                <li><a class="s-messenger" target="_blank" href="{{ \App\Setting::MESSENGER_MOBILE_BASE_URL.env('FACEBOOK_APP_ID')
                .'&link='.urlencode(route('page.educator', Auth::user()->slug)) }}">Messenger</a>
                                </li>
                                <li><a class="s-facebook" target="_blank"
                                       href="{{ \App\Setting::FACEBOOK_SHARE_URL.env('FACEBOOK_APP_ID').'&href='.
                                       urlencode(route('page.educator', Auth::user()->slug)).'&display=page&redirect_uri='.
                                       urlencode(route('page.educator', Auth::user()->slug))  }}">Facebook</a>
                                </li>
                                <li><a class="s-whatsapp" target="_blank"
                                       href="{{ \App\Setting::WHATSAPP_MOBILE_SHARE_URL }}{{ route('page.educator', Auth::user()->slug) }}">WhatsApp</a>
                                </li>
                            @else
                                <li><a class="s-messenger" target="_blank" href="{{ \App\Setting::MESSENGER_BASE_URL.env('FACEBOOK_APP_ID')
                .'&link='.route('page.educator', Auth::user()->slug).'&redirect_uri='.route('page.educator', Auth::user()->slug) }}">Messenger</a>
                                </li>
                                <li><a class="s-facebook" target="_blank"
                                       href="{{ \App\Setting::FACEBOOK_SHARE_URL.env('FACEBOOK_APP_ID').'&href='.
                                       urlencode(route('page.educator', Auth::user()->slug)).'&display=page&redirect_uri='.
                                       urlencode(route('page.educator', Auth::user()->slug))  }}">Facebook</a>
                                </li>
                                <li><a class="s-whatsapp" target="_blank"
                                       href="{{ \App\Setting::WHATSAPP_SHARE_URL }}{{ route('page.educator', Auth::user()->slug) }}">WhatsApp</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- end: or, with other social media options -->
                </div>

            </div>
        </div>
    </div>
</div>
<!--end:: step2-category-not-into-profile Modal-->
