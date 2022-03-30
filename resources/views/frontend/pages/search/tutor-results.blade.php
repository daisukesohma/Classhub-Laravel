<!-- starts: search-results tiles container -->
<div class="container search-results">
  <div class="row">
    <div class="col-md-8">
      @if( count($tutorResults))
      <!-- Starts: Tiles type 01 -->
          <div class="row title-type-01">
              <div class="col-sm-12">
                  <div class="title p-b-10">TOP TUTORS</div>
                  @if(!$desktop)
                      <div class="sub-title">Check out some of the most popular classes in your area</div>
                  @endif
              </div>
          </div>
          <!-- Starts: Tiles type 01 -->
      @else
          <div class="row title-type-01">
              <div class="col-sm-12">
                  <div class="title color-02 p-t-50 p-b-50">No results matching your search were found</div>
              </div>
          </div>
      @endif

  <!-- Starts: Tiles type 02 -->
      <div class="row tiles-type-02 p-b-50">
          <div class="show-more-featured-container">
              <!-- starts : tile 01 -->
              @foreach($tutorResults as $tutorUser)
                  <div class="col-xs-12 col-md-4 col-sm-6">
                      <a href="{{ route('page.educator', $tutorUser->slug)  }}">

                          <div class="image-tile  col-eq-height {{ $tutorUser->trusted ? 'trusted' : '' }}"
                               style="padding-bottom: 80px">
                              <div class="profile-image-lesson"
                                   style="background-image: url({{  \App\Helpers\ClassHubHelper::getImagePath(null, $tutorUser->educator->photo) }});">
                                  <div class="price">
                                      @if($tutorUser->educator->base_price)

                                          <div class="price-dot">
                                              <span>€{{ $tutorUser->educator->base_price }}</span>
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
                              @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($tutorUser->ratings)])
                              <!-- end: Rating -->
                                  <div class="name">{{ $tutorUser->name }}</div>
                                  <div class="tutor-subjects color-02">

                                  </div>
                                  <hr>
                                  <div class="row" style="text-align: center">
                                      <?php
                                      $count = $tutorUser->lessons()->where('status', 'live')->where('type', '!=', 'subject')->get()
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
                                              <div
                                                  class="">{{ $count  }}
                                              </div>

                                          </div>
                                      @endif
                                      {{--@if($desktop)--}}
                                          <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                                              <h5 class="detail-title"
                                                  style="">Areas I Cover:</h5>
                                              <div class="one-line">{{ $tutorUser->locations}}</div>
                                          </div>
                                      {{--@endif--}}
                                      <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                                          <h5 class="detail-title">Subjects:</h5>
                                          <div class="one-line">
                                              @foreach($tutorUser->categories as $key => $subject)
                                                  @php $displayName = \App\Helpers\ClassHubHelper::getSubjectDisplayName($subject, $tutorUser->categories)  @endphp
                                                  @if($displayName)
                                                      {{ $displayName }}{{ isset($tutorUser->categories[$key+1]) ? ', ' : '' }}
                                                  @endif
                                              @endforeach
                                          </div>
                                      </div>
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

              @if($tutorResults->nextPageUrl())
                  <div class="row showmore p-t-55 show-more-featured-button-container">
                      <div class="col-sm-12 text-center">
                          <a class="btn btn-brand shadow-v4 show-more-featured-button"
                             href="{{ $tutorResults->nextPageUrl() }}" style="padding: 0 40px;">
                              <span class="btn__text">SHOW MORE</span>
                          </a>
                      </div>
                  </div>
              @endif

          </div>
      </div>
      <!-- End: Tiles type 02 -->
    </div>
  </div>
</div>
<!-- End: search-results tiles container -->
