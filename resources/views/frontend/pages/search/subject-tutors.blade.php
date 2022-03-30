@if($categoryId)
    <!-- starts: search-results tiles container -->
    <div class="container search-results" id="subject-tutors">
      <div class="row">
        <div id="filter-results" class="col-md-4 only-mobile">
          <details>
            <summary>Filter Results <svg width="25" height="10" viewBox="0 0 35 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.4994 20L0 4.59058L5.2132 0L17.4994 10.8199L29.7868 0L35 4.59058L17.4994 20Z" fill="#fff"/></svg>
            </summary>
            {{ Form::open(['url' => route('page.search'), 'method' => 'GET', 'id' => 'filter-form-mob']) }}
              <div id="filters">
                <input type="hidden" name="category_id" value="{!! $categoryId !!}">
                <div id="filter-price">
                  <label class="filter-label">Filter by price</label>
                  <select name="price_sort" class="form-control">
                    <option value="desc" {{ $filter['price_sort'] == 'desc' ? 'selected' : '' }}>High to Low</option>
                    <option value="asc" {{ $filter['price_sort'] == 'asc' ? 'selected' : '' }}>Low to High</option>
                  </select>
                  <div class="slider-styled" id="price-range-slider-mob"></div>
                  <span id="price-values-mob">
                    €<span class="example-val" id="price-range-slider-value-mob">0.00 - €0.00</span>
                    <input type="hidden" name="price_from">
                    <input type="hidden" name="price_to">
                  </span>
                </div>

                <div id="filter-level">
                  <label class="filter-label">Filter by Tutor Level</label><br>
                  <div id="tutor-level-options">
                    <label class="fs-13">
                      <input type="radio" name="tutor_level" value="all" 
                        {{ $filter['tutor_level'] ? ($filter['tutor_level'] == 'all' ? 'checked' : '') : 'checked' }}
                      > 
                      All Tutors
                    </label>
                    <label class="fs-13">
                      <input type="radio" name="tutor_level" value="trusted" {{ $filter['tutor_level'] == 'trusted' ? 'checked' : '' }}> 
                      Trusted
                    </label>
                    <label class="fs-13">
                      <input type="radio" name="tutor_level" value="top" {{ $filter['tutor_level'] == 'top' ? 'checked' : '' }}> 
                      Top Performers
                    </label>
                  </div>
                </div>

                <div id="filter-time">
                  <label class="filter-label">Filter by Time</label><br>
                  <div class="row">
                    <div class="col-sm-12 col-md-5">
                      <input
                          type="text"
                          class="form-control timepicker_from"
                          name="from"
                          placeholder="From">
                    </div>
                    <div class="col-sm-12 col-md-5">
                      <input
                          type="text"
                          class="form-control timepicker_to"
                          name="to"
                          placeholder="To">
                    </div>
                  </div>
                </div>
                <button class="btn btn-brand w-100">Update Results</button>
              </div>
            {{ Form::close() }}
          </details>
        </div>
        <div class="col-md-8">
          @if(count($subjectTutors))
            <!-- Starts: Tiles type 01 -->
              <div class="row title-type-01">
                  <div class="col-sm-12">
                      <div class="title p-b-10">OUR TUTORS</div>
                      @if(!$desktop)
                          <div class="sub-title">Check out some of the most popular classes in your area</div>
                      @endif
                  </div>
              </div>
            <!-- End: Tiles type 01 -->
            <!-- Starts: Tiles type 02 -->
              <div class="row tiles-type-02 p-b-50">
                <div class="show-more-subject-tutors-container">
                    <!-- starts : tile 01 -->
                    @foreach($subjectTutors as $user)

                        <div class="col-xs-12 col-md-4 col-sm-6">
                            <a href="{{ route('page.educator', $user->slug)  }}">

                                <div class="image-tile  col-eq-height {{ $user->trusted ? 'trusted' : '' }}"
                                    style="padding-bottom: 80px">
                                    <div class="profile-image-lesson"
                                        style="background-image: url({{  \App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo) }});">
                                        <div class="price">
                                            @if($user->educator->base_price)
                                                <div class="price-dot">
                                                    <span>€{{ $user->educator->base_price }}</span>
                                                </div>
                                                <span class="tutor-subjects color-02"> /hr</span>
                                            @else
                                                <div class="price-dot book-now-dot">
                                                    <span>Book now</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="tile-details tutor-details" style="padding-bottom: 0px">

                                        <!-- starts: Rating -->
                                    @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($user->ratings)])
                                    <!-- end: Rating -->
                                        <div class="name">{{ $user->name }}</div>
                                        <div class="tutor-subjects color-02">
                                            {{ implode(' - ', $user->educator->teaching_types) }}
                                        </div>
                                        @if(in_array($categoryId, $user->topPerformerCategories()->pluck('category_id')->toArray()))
                                          <div class="top-performer">
                                            <hr class="top-performer-line">
                                            <div class="badge-outline-primary top-performer-badge">Top Performer</div>
                                          </div>
                                        @endif
                                        <div class="row">
                                            <?php
                                            $count = $user->lessons()->where('status', 'live')->where('type', '!=', 'subject')->get()
                                                ->filter(function ($lesson) {
                                                    $firstClass = $lesson->classes->first();
                                                    $lastClass = $lesson->classes->last();
                                                    $classStartAt = \Carbon\Carbon::parse($firstClass->date . ' ' . $firstClass->start_time);
                                                    $classEndAt = \Carbon\Carbon::parse($lastClass->date . ' ' . $lastClass->start_time);

                                                    if ($lesson->type == 'single') {
                                                        $bookableClasses = $lesson->classes()->where('bookable', 1)->get();

                                                        return $lesson->status == 'live' && $bookableClasses->isNotEmpty() && $classEndAt->isFuture();
                                                    } else {
                                                        return $lesson->status == 'live' && $lesson->bookable && $classStartAt->isFuture();
                                                    }

                                                })->count();

                                            ?>
                                            @if($count)
                                                <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                                                    <h5 class="detail-title"
                                                        style="">Classes: </h5>
                                                    <div class="">{{ $count }}</div>
                                                </div>
                                            @endif
                                            <div class="col-md-12 col-sm-12 col-xs-12 details-section"
                                                style="position: absolute; bottom: 0; left: 0;">
                                                <button class="btn btn-brand">CONTACT NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </a>
                        </div>

                    @endforeach
                <!-- end : tile 01 -->

                    @if($subjectTutors->nextPageUrl())
                        <div class="row showmore p-t-55 show-more-subject-tutors-button-container"
                            id="subject-tutors-more-link">
                            <div class="col-sm-12 text-center">
                                <a class="btn btn-brand shadow-v4 show-more-subject-tutors-button"
                                  href="{{ $subjectTutors->nextPageUrl() }}" style="padding: 0 40px;">
                                    <span class="btn__text">SHOW MORE</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
              </div>
            <!-- End: Tiles type 02 -->

          @else
            <div class="row title-type-01">
              <div class="col-sm-12">
                  <div class="title color-02 p-t-50 p-b-50">No results matching your search were found</div>
              </div>
            </div>
          @endif

        </div>
        <div id="filter-results" class="col-md-4 only-desktop">
          <div class="row title-type-01">
              <div class="col-sm-12">
                  <div class="title p-b-10 filter-results-title">Filter Results</div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                {{ Form::open(['url' => route('page.search'), 'method' => 'GET', 'id' => 'filter-form']) }}
                  <div id="filters">
                    <input type="hidden" name="category_id" value="{!! $categoryId !!}">
                    <div id="filter-price">
                      <label class="filter-label">Filter by price</label>
                      <select name="price_sort" class="form-control">
                        <option value="desc" {{ $filter['price_sort'] == 'desc' ? 'selected' : '' }}>High to Low</option>
                        <option value="asc" {{ $filter['price_sort'] == 'asc' ? 'selected' : '' }}>Low to High</option>
                      </select>
                      <div class="slider-styled" id="price-range-slider"></div>
                      <span id="price-values">
                        €<span class="example-val" id="price-range-slider-value">0.00 - €0.00</span>
                        <input type="hidden" name="price_from">
                        <input type="hidden" name="price_to">
                      </span>
                    </div>

                    <div id="filter-level">
                      <label class="filter-label">Filter by Tutor Level</label><br>
                      <div id="tutor-level-options">
                        <label class="fs-13">
                          <input type="radio" name="tutor_level" value="all" 
                            {{ $filter['tutor_level'] ? ($filter['tutor_level'] == 'all' ? 'checked' : '') : 'checked' }}
                          > 
                          All Tutors
                        </label>
                        <label class="fs-13">
                          <input type="radio" name="tutor_level" value="trusted" {{ $filter['tutor_level'] == 'trusted' ? 'checked' : '' }}> 
                          Trusted
                        </label>
                        <label class="fs-13">
                          <input type="radio" name="tutor_level" value="top" {{ $filter['tutor_level'] == 'top' ? 'checked' : '' }}> 
                          Top Performers
                        </label>
                      </div>
                    </div>

                    <div id="filter-time">
                      <label class="filter-label">Filter by Time</label><br>
                      <div class="row">
                        <div class="col-sm-12 col-md-5">
                          <input
                              type="text"
                              class="form-control timepicker_from"
                              name="from"
                              placeholder="From">
                        </div>
                        <div class="col-md-2 text-center">
                          <span class="from-to-hyphen" style="margin-top: 10px; display: block">-</span>
                        </div>
                        <div class="col-sm-12 col-md-5">
                          <input
                              type="text"
                              class="form-control timepicker_to"
                              name="to"
                              placeholder="To">
                        </div>
                      </div>
                    </div>
                    <button class="btn btn-brand w-100">Update Results</button>
                  </div>
                {{ Form::close() }}
              </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End: search-results tiles container -->

    <script>
        @if(isset($filter))
      var filter = {!! json_encode($filter) !!}
        @else
      var filter = {}
        @endif
    </script>
@endif
