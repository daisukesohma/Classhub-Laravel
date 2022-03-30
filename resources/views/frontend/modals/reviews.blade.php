<!--begin::Modal-->
<div class="modal fade c-modal see-reviews" id="see-reviews" tabindex="-1" role="dialog" aria-labelledby=""
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- starts : body -->
                <div class="list-a-class">

                    <div class="top-section">
                        <div class="title p-l-0">My Reviews</div>
                        <!-- starts: Rating -->
                    @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($user->ratings)])

                    <!-- end: Rating -->

                        <!-- starts: Image -->
                        <div class="image">
                            <div class="profile-image-lesson {{ $user->trusted ? 'trusted' : '' }}"
                                 style="background-image: url({{ \App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo) ?
                                             \App\Helpers\ClassHubHelper::getImagePath(null, $user->educator->photo) :
                                             asset('/img/profile-placeholder.jpg') }})">
                            </div>
                        </div>
                        <!-- End: Image -->

                    </div>

                    <!-- starts : btm-section -->
                    <div class="btm-section reviews">

                        <div class="scrollable">
                          @if( count($user->ratings) == 0)
                          <div class="emptyState">
                            <h4 class="text-center p-t-60 p-b-60">This tutor has no reviews yet</h4>
                          </div>
                          @else

                            @foreach($user->ratings as $rating)

                                <!-- starts : review 01 -->
                                    <div class="row review">

                                        <!-- starts : column, left -->
                                        <div class="col-xs-4 col-md-3 text-center">
                                            <div class="letters" style="background-color:#008F94;">
                                                {{ \App\Helpers\ClassHubHelper::getInitials($rating->parent->name) }}
                                            </div>
                                            <div class="name">{{ $rating->parent->name }}</div>
                                            <!-- starts: Rating -->
                                        @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings(collect([$rating]))])

                                        <!-- end: Rating -->
                                        </div>
                                        <!-- end : column, left -->

                                        <!-- starts : column, right -->
                                        <div class="col-xs-8 col-md-9">
                                            <div class="msg">
                                                {{ $rating->comment }}
                                            </div>
                                            <div class="date">{{ $rating->created_at->format('d F, Y') }}</div>
                                        </div>
                                        <!-- end : column, right -->

                                    </div>

                            @endforeach
                          @endif
                        <!-- end : review 01 -->
                        </div>

                    </div>
                    <!-- end : btm-section -->

                </div>
                <!-- end : body -->
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
