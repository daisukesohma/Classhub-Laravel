<div class="">

    <!-- starts: Image -->
    <div class="image tag-price">
        <img class="img-circle shadow-v3 rate-me-pp" alt="image" style="width: 70px; height: 70px" src="
            {{ Storage::disk('public')->exists(  optional($lesson->user->educator->avatar)->path ) ?
                Storage::url(optional($lesson->user->educator->avatar)->path) :
                asset('img/icons/common/parents-burger-menu.png') }}"/>
    </div>
    <!-- End: Image -->

    @if($rating)

        <br>
        @include('common.rating-v2',
                                    ['rating' => \App\Helpers\ClassHubHelper::ratings($lesson->ratings())])

        <style type="text/css">
            .rating.v2 .star {
                width: 30px;
                height: 30px;
            }
        </style>

    @else

        <div class="msg fs-25 fw-4 p-t-12">Tap a star to leave a review</div>

        {!! Form::open(['url' => route('parent.lesson.rating.store', $lesson->id), 'id' => 'rate-me-form']) !!}
    <!-- starts: fieldset Rating -->
        <fieldset class="rating" style="padding-bottom: 20px">

            <input type="radio" id="star5" name="rating" value="5"/>
            <label class="full" for="star5"
                   title="Awesome - 5 stars"></label>
            <input type="radio" id="star4" name="rating" value="4"/>
            <label class="full" for="star4"
                   title="Pretty good - 4 stars"></label>
            <input type="radio" id="star3" name="rating" value="3"/>
            <label class="full" for="star3"
                   title="Meh - 3 stars"></label>
            <input type="radio" id="star2" name="rating" value="2"/>
            <label class="full" for="star2"
                   title="Kinda bad - 2 stars"></label>
            <input type="radio" id="star1" name="rating" value="1"/>
            <label class="full" for="star1"
                   title="Sucks big time - 1 star"></label>

        </fieldset>
        <!-- end: fieldset Rating -->

        <div class="form-group">
            <textarea class="form-control" name="comment" required rows="5" placeholder="Leave a review here"></textarea>
        </div>

        <div class="row">
            <div class="col-xs-6">
                <a href="javascript:void(0)" class="btn btn-sm btn-white shadow-v3" data-dismiss="modal">
                    <span class="btn__text">Cancel</span>
                </a>
            </div>
            <div class="col-xs-6">
                <button type="submit" href="javascript:void(0)" class="btn btn-sm btn-primary shadow-v3">
                    <span class="btn__text">Submit</span>
                </button>
            </div>
        </div>

        {!! Form::close() !!}

    @endif
</div>
