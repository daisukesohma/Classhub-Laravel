<div class="col-xs-12 col-md-3 col-sm-6">
    <a href="{{ route('page.educator', $educator->user->slug)  }}">

        <div class="image-tile  col-eq-height {{ $educator->user->trusted ? 'trusted' : '' }}">
            <div class="profile-image-lesson"
                 style="background-image: url({{  \App\Helpers\ClassHubHelper::getImagePath(null, $educator->photo) }});">
                 <div class="price">
                   <div class="price-dot">
                     <span>€100</span>
                   </div>
                   <span class="tutor-subjects color-02"> /hr</span>
                 </div>
            </div>
            <div class="tile-details tutor-details" style="padding-bottom: 0px">

              <!-- starts: Rating -->
          @include('frontend.includes.rating', ['rating' => \App\Helpers\ClassHubHelper::ratings($educator->user->ratings)])
          <!-- end: Rating -->
                <div class="name">{{ $educator->user->name }}</div>
                <div class="tutor-subjects color-02">
                    {{ implode(' - ', $educator->teaching_types) }}
                </div>
                <hr>
                <div class="row">
                    @if($educator->user->lessons()->where('status','live')->where('type', '!=', 'subject')->get()->count())
                        <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                            <h5 class="detail-title"
                                style="">Classes: </h5>
                            <div class="">{{ $educator->user->lessons()->where('status','live')->where('type', '!=', 'subject')->get()->count()  }}</div>

                        </div>
                    @endif
                    <div class="col-md-12 col-sm-12 col-xs-12 details-section">
                        <h5 class="detail-title"
                            style="">Areas I Cover:</h5>
                        <div class="">{{ $educator->user->locations}}</div>
                    </div>
                    {{--<div class="col-md-12 col-sm-12 col-xs-12 details-section">
                        <h5 class="detail-title">Subjects:</h5>
                        <ul class="text-left">
                            @foreach($educator->user->categories as $subject)
                                @php $displayName = \App\Helpers\ClassHubHelper::getSubjectDisplayName($subject, $educator->user->categories)  @endphp
                                @if($displayName)
                                    <li>{{ $displayName }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>--}}
                </div>
            </div>
        </div>

    </a>
</div>
