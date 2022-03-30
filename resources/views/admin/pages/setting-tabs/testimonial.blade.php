<div class="tab-pane {{ request()->get('tab') == 'testimonial' ? 'active': '' }}" id="testimonials">
    <div class="m-portlet__body">
        <div class="row" style="padding: 0em 4em">
            <h5>Drag Testimonials into the order you want them displayed...</h5>
        </div>
        {!! Form::open(['url' => route('admin.testimonial.sort'), 'id' => 'testimonial-sort-form']) !!}

        <div class="row ui-sortable testimonial-sortable" style="padding: 3em 3em 0em 3em" id="m_sortable_portlets_2">
            @if(count($testimonialGrids))
                @foreach($testimonialGrids as $cols)
                    <div class="col-lg-4">
                        @foreach($cols as $row)
                            <div class="m-portlet m-portlet--mobile m-portlet--sortable testimonial-container">
                                {!! Form::hidden('testimonials[]', $row['id']) !!}
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <p class="m-portlet__head-text testimonial">
                                            <em>"{{ $row['content'] }}"</em>
                                        </p>
                                    </div>
                                </div>
                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h5 class="m-portlet__head-text">{{ $row['for'] }} : {{ $row['name'] }}
                                                , Rating : {{ $row['rating'] }}</h5>
                                        </div>
                                    </div>
                                    <div class="m-portlet__head-tools">
                                        <ul class="m-portlet__nav">
                                            <li class="m-portlet__nav-item">
                                                <a href="javascript:;" data-id="{{ $row['id'] }}"
                                                   data-route="{{ route('admin.testimonial.delete', $row['id']) }}"
                                                   class="delete-testimonial m-portlet__nav-link btn btn-danger m-btn
                                                    m-btn--icon m-btn--icon-only m-btn--pill">
                                                    <i class="la la-close"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="m-portlet m-portlet--mobile m-portlet--sortable" style="visibility: hidden;">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <p class="m-portlet__head-text testimonial">
                                        <em></em>
                                    </p>
                                </div>
                            </div>
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h5 class="m-portlet__head-text"></h5>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="m-portlet__nav">
                                        <li class="m-portlet__nav-item">
                                            <a href="#"
                                               class="m-portlet__nav-link btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill">
                                                <i class="la la-close"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {!! Form::close() !!}

        <div class="m-portlet m-portlet--rounded" style="margin: 0% 4%">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Add Testimonial
                        </h3>

                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                {!! Form::open(['url' => route('admin.testimonial.store'), 'class' => 'm-form m-form--fit']) !!}

                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-2 col-form-label">
                        Tutor Image
                    </label>

                    <div class="col-9">
                        <div class="m-dropzone dropzone" action="{{ route('upload.image', 'testimonials') }}"
                             id="dropzone-three">
                            <div class="m-dropzone__msg dz-message needsclick">
                                <h3 class="m-dropzone__msg-title">
                                    Drop image file here or click to upload.
                                </h3>

                                <span class="m-dropzone__msg-desc">
																	</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-2 col-form-label">
                        Testimonial
                    </label>

                    <div class="col-9">
                        {!! Form::textarea('content', null, ['class' => 'form-control m-input',
                         'rows' => 4, 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-2 col-form-label">
                        Name
                    </label>

                    <div class="col-9">
                        <label class="m-radio">
                            <input type="radio" name="for" value="Parent" checked="checked"> Parent
                            <span></span>
                        </label>
                        <label class="m-radio" style="margin-left: 10px">
                            <input type="radio" name="for" value="Teacher"> Teacher
                            <span></span>
                        </label>
                    </div>

                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-2 col-form-label">
                    </label>

                    <div class="col-9">
                        {!! Form::text('name', null, ['class' => 'form-control m-input', 'required' => 'required']) !!}
                    </div>

                </div>
                <div class="form-group m-form__group row">
                    <label for="example-text-input" class="col-2 col-form-label">
                        Rating
                    </label>

                    <div class="col-9">
                        {!! Form::select('rating', \App\Setting::RATING_OPTIONS, null, ['class' => 'form-control m-input']) !!}
                    </div>
                </div>
                <div class="m-form__actions">
                    <div class="row">
                        <div class="col-7">
                            <button type="submit"
                                    class="btn btn-brand m-btn m-btn--air m-btn--custom">
                                Add Testimonial
                            </button>

                        </div>
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>

</div>
