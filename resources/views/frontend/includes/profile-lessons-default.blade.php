@foreach($liveLessons as $lesson)
    <!-- starts : tile 01 -->
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <a href="{{ route('page.lesson', $lesson->slug)  }}">

            <div class="image-tile outer-title col-eq-height tutor-lesson-cards my-classes">

                <img alt="Pic" class="product-thumb"
                     src="{{ $lesson->images->count() ? Storage::url($lesson->images->first()->path)
                             : 'https://dummyimage.com/460x320/000/fff' }}"
                     style="object-fit: cover; width: 100%; height: 190px"
                />

                <div class="tile-details">
                    <div class="row">
                        <div class="col-md-12 p-t-0">
                            <h5 class="fw-7 lesson-name m-b-0">{{ $lesson->name }}</h5>
                            <div class="location fw-4 color-01-a">
                                {{ $lesson->location ? $lesson->location : optional($lesson->areas->first())->address }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-7 col-md-12 p-t-0">
                            <p class="students"><strong>Students:</strong>
                                {{ $lesson->max_num_bookings == 1 ? 'One-to-one' : 'Group of Students'  }}
                            </p>
                            <p class="class-type"><strong>Type:</strong>
                                {{ $lesson->type == 'single' || $lesson->type == 'subject' ? 'Single' : ucwords($lesson->type).' of classes' }}
                            </p>
                        </div>
                        <div class="col-lg-5 col-md-12 col-sm-12 p-t-0">
                            <!-- starts: price -->
                            <div class="price">
                                <div class="color-02-a text-center text-sm-left">
                                    <strong><span>{{ $lesson->display_price }} </span></strong>
                                    {{ \App\Helpers\ClassHubHelper::lessonTypePriceText($lesson) }}
                                </div>
                            </div>
                            <!-- end: price -->
                        </div>
                    </div>

                </div>

            </div>

        </a>
    </div>
    <!-- end : tile 01 -->
@endforeach
