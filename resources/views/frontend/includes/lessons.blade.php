@foreach($lessons as $lesson)
    <!-- starts : tile 01 -->
    <div class="col-xs-12 col-md-3 col-sm-6">
        <a href="{{ route('page.lesson', $lesson->slug)  }}">

            <div class="image-tile outer-title class-tile equal-height">

                <img alt="Pic" class="product-thumb"
                     src="{{ $lesson->images->count() ? Storage::url($lesson->images->first()->path)
                             : 'https://dummyimage.com/460x320/000/fff' }}"
                     style="object-fit: cover; width: 100%; height: 190px"
                />

                <div class="tile-details">

                    <!-- t-dt-les-loc : Tile details lesson location -->
                    <div data-mh="t-dt-les-loc" class="location fw-4 color-01-a">
                        {{ $lesson->location ? $lesson->location : optional($lesson->areas->first())->address }}
                    </div>
                    <div class="name fw-4">{{ $lesson->name }}</div>
                    <div class="provideby color-01-a">Provided by <b>{{ optional($lesson->user)->name }}</b></div>

                    <!-- starts: price -->
                    <div class="class-price">
                        <div class="color-01-a"><strong><span>{{ $lesson->display_price }} </span></strong>
                            {{ \App\Helpers\ClassHubHelper::lessonTypePriceText($lesson) }}
                        </div>
                    </div>
                    <!-- end: price -->

                </div>

            </div>

        </a>
    </div>
    <!-- end : tile 01 -->
@endforeach
