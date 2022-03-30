<div class="modal fade c-modal overlay-share-this" id="share-profile-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 0 15px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">
          &times;
        </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="overlay-share-content list-a-class">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group p-t-0">
                                <label class="fw-3" for="email">Share by email <span class="info-badge m-l-14"
                                                                                     data-toggle="popover"
                                                                                     data-placement="top"
                                                                                     data-html="true"
                                                                                     data-content="Add in the person's email that you want to share this with">i</span></label>
                                <input type="email" required class="form-control" id="share-to-email"
                                       name="share_email"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-right" style="padding-top: 20px;">
                                <button type="submit" data-educator-id="{{ $user->id }}"
                                        data-share-route="{{ route('share.educator', $user->id) }}"
                                        class="btn btn-sm btn-primary shadow-v3 m-b-20 share-profile-btn">
                                    <span class="btn__text">Send</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center" id="result" style="color:#1e6f5f "></div>
                            <div class="text-center" id="error" style="color: #E74B65"></div>
                        </div>
                    </div>

                    <div class="or m-b-14"><span><i>or</i></span></div>

                    <!-- starts: or, with other social media options -->
                    <div class="socailmedia-share">
                        <ul class="list">
                            @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
                                <li><a class="s-messenger" target="_blank" href="{{ \App\Setting::MESSENGER_MOBILE_BASE_URL.env('FACEBOOK_APP_ID')
                .'&link='.urlencode(route('page.educator', $user->slug)) }}">Messenger</a>
                                </li>
                                <li><a class="s-facebook" target="_blank"
                                       href="{{ \App\Setting::FACEBOOK_SHARE_URL.env('FACEBOOK_APP_ID').'&href='.
                                       urlencode(route('page.educator', $user->slug)).'&display=page&redirect_uri='.
                                       urlencode(route('page.educator', $user->slug))  }}">Facebook</a>
                                </li>
                                <li><a class="s-whatsapp" target="_blank"
                                       href="{{ \App\Setting::WHATSAPP_MOBILE_SHARE_URL }}{{ route('page.educator', $user->slug) }}">WhatsApp</a>
                                </li>
                            @else
                                <li><a class="s-messenger" target="_blank" href="{{ \App\Setting::MESSENGER_BASE_URL.env('FACEBOOK_APP_ID')
                    .'&link='.route('page.educator', $user->slug).'&redirect_uri='.route('page.educator', $user->slug) }}">Messenger</a>
                                </li>
                                <li><a class="s-facebook" target="_blank"
                                       href="{{ \App\Setting::FACEBOOK_SHARE_URL.env('FACEBOOK_APP_ID').'&href='.
                                       urlencode(route('page.educator', $user->slug)).'&display=page&redirect_uri='.
                                       urlencode(route('page.educator', $user->slug)) }}">Facebook</a>
                                </li>
                                <li><a class="s-whatsapp" target="_blank"
                                       href="{{ \App\Setting::WHATSAPP_SHARE_URL }}{{ route('page.educator', $user->slug) }}">WhatsApp</a>
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
