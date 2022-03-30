<!-- starts : drop own images -->
{{--<div class="drop-images photo-bio">
    <div class="title">Drop your own images or choose from our gallery…</div>
    <div class="m-dropzone dropzone" action="{{ route('upload.image', 'class-images') }}" id="dropzone-two">
        <div class="m-dropzone__msg dz-message needsclick">
            <div class="m-dropzone__msg-title">Drag photos here or click to upload.</div>
        </div>
    </div>
</div>--}}
<!-- end : drop own images -->
<!-- starts : choose images -->
<div class="choose-images">
    <div class="m-scrollable" data-scrollable="true" data-max-height="400" data-scrollbar-shown="true">
        <div class="m-portlet__body">
            <div class="m-form__section m-form__section--first">
                <div class="form-group m-form__group">
                    <div class="row" id="gallery-images">
                        @if($images->count())
                            @foreach($images as $image)
                                <div class="col-6 col-md-4 img">
                                    <label class="m-option">
													<span
                                                        class="m-checkbox m-checkbox--air m-checkbox--solid m-checkbox--state-brand">
														<input type="radio" name="gallery_images[]"
                                                               value="{{ $image->id }}"
                                                               data-name=" {{ $image->title }}"
                                                               data-src="{{ App\Helpers\ClassHubHelper::getImagePath($image)  }}">
														<span></span>
													</span>
                                        <img alt="Pic" class="product-thumb lazy"
                                             data-src="{{ route('home') }}{{ Storage::url($image->path) }}"/>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end : choose images -->

<!-- starts : upload image -->
<div class="upload-button text-center">
    <a class="btn btn-primary v1 shadow-v4 select-images" href="javascript:void(0);">
        <span class="btn__text">Select Images</span>
    </a>
</div>
<!-- end : upload image -->

<script type="text/javascript">
    $(function () {
        $('.lazy').lazy({
            effect: 'fadeIn',
            placeholder: "data:image/gif;base64,R0lGODlhEALAPQAPzl5uLr9Nrl8e7..."
        });
    })
</script>
