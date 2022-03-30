<div class="tab-pane {{ !request()->get('tab')  ? 'active': '' }}" id="m_user_profile_tab_1">
    {!! Form::open(['url' => route('admin.homepage.setting.store'), 'method' => 'POST',
        'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
    <div class="m-portlet__body">
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                Heading
            </label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control m-input" type="text" name="heading"
                       placeholder="Find your child's hidden talents"
                       value="{{ \App\Setting::get('heading') }}">
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                Subheading
            </label>
            <div class="col-md-7 col-sm-12">
                <input class="form-control m-input" type="text" name="sub_heading"
                       placeholder="Join Classhub for free today"
                       value="{{ \App\Setting::get('sub_heading') }}">
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                Banner Images
            </label>
            <div class="col-md-7 col-sm-12">
                <div class="m-dropzone dropzone" action="{{ route('upload.image', 'banner') }}"
                     id="dropzone-one">
                    @if( \App\Setting::get('banner_images'))
                        @foreach(unserialize(\App\Setting::get('banner_images')) as $id)
                            <div class="dz-preview dz-processing dz-image-preview dz-complete banner-image">
                                <div class="dz-image">
                                    <img style="height: 120px"
                                         src="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $id) }}"
                                         data-dz-thumbnail=""/>
                                    <div class="file-placeholder">
                                        <i class="fa fa-file-text"></i>
                                    </div>
                                </div>
                                <div class="dz-details">
                                    <div class="dz-size">
                                        <span data-dz-size=""><strong></strong></span>
                                    </div>
                                    <div class="dz-filename">
                                <span data-dz-name="">
                                    <a target="_blank" style="cursor:pointer;"

                                       href="{{ \App\Helpers\ClassHubHelper::getImagePath(null, $id) }}">View Banner</a>
                                </span>
                                    </div>
                                </div>

                                <div class="dz-progress">
                            <span class="dz-upload" data-dz-uploadprogress=""
                                  style="width: 100%;">

                            </span>
                                </div>
                                <a class="dz-remove delete-banner" href="javascript:;"
                                   data-dz-remove="" data-route="{{ route('admin.banner.delete', $id) }}"
                                >Delete Image</a>
                                <input name="banner_images[]" value="{{ $id  }}" type="hidden">
                            </div>
                        @endforeach
                    @else
                        <div class="m-dropzone__msg dz-message needsclick">
                            <h3 class="m-dropzone__msg-title">
                                Drop image files here or click to upload.
                            </h3>

                            <span class="m-dropzone__msg-desc">
                              For best results, upload image size: 1980 x 990px
																	</span>

                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                Banner Overlay
            </label>

            <div class="col-md-7 col-sm-12">
                {!! Form::select('banner_overlay', \App\Setting::OVERLAYS, \App\Setting::get('banner_overlay'),
                    ['class' => 'form-control']) !!}
            </div>
        </div>
        {{--<div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-2 col-sm-12 col-form-label">
                Trusted by logos
            </label>
            <div class="col-md-7 col-sm-12">
                <div class="thumbs col-md-12" style="margin-bottom: 30px;">
                    @if($trustedLogos = @unserialize(\App\Setting::get('trusted_logos')))
                        @foreach($trustedLogos as $logo)
                            <a target="_blank" class="logo"
                               href="javascript:;">
                                <img class="thumb" src="{{ \App\Helpers\ClassHubHelper::getImagePath($logo) }}"
                                     alt="rte logo" style="margin-bottom: 20px">
                                <button class="btn delete-trusted-logo" type="button" data-id="{{ $logo }}"
                                        data-route="{{ route('admin.trusted.logo.delete', $logo) }}">
                                    <i class="fa fa-close"></i>
                                </button>
                                <input type="hidden" name="trusted_logos[]" value="{{ $logo }}">
                            </a>
                        @endforeach
                    @endif

                </div>
                <div class="m-dropzone dropzone" action="{{ route('upload.image', 'trusted-logos') }}"
                     id="dropzone-two">
                    <div class="m-dropzone__msg dz-message needsclick">
                        <h3 class="m-dropzone__msg-title">
                            Drop image files here or click to upload.
                        </h3>
                        <span class="m-dropzone__msg-desc"></span>
                    </div>
                </div>
            </div>
        </div>--}}
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <button type="submit"
                            class="btn btn-brand m-btn m-btn--air m-btn--custom">
                        Save changes
                    </button>
                    &nbsp;&nbsp;
                    <button type="reset"
                            class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                        Cancel
                    </button>

                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
