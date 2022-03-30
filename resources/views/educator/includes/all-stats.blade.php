<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Times profile appeared in search
        <div class="number"><i class="la la-search"></i> {{ $numSearches }}</div>
    </div>
</div>
<!-- end : list 01 -->

<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Times profile was viewed
        <div class="number"><i class="fa fa-eye"></i> {{ $profileViews }}</div>
    </div>
</div>
<!-- end : list 01 -->

<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Times adverts were viewed
        <div class="number"><i class="la la-volume-up"></i> {{ $lessonViews }}</div>
    </div>
</div>
<!-- end : list 01 -->

<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Times added to favourites
        <div class="number"><i class="fa fa-heart-o"></i> {{ $numLikes }}</div>
    </div>
</div>
<!-- end : list 01 -->

<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Average rating
        <div class="number"><i class="la la-star-o"></i> {{ $rating }}</div>
    </div>
</div>
<!-- end : list 01 -->

<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Total bookings
        <div class="number"><i class="la la-check-square"></i> {{ $numBookings }}</div>
    </div>
</div>
<!-- end : list 01 -->

<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Monthly Sales
        <div class="number"><i class="fa fa-euro"></i>
            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($avgBookingAmount), 2) }}</div>
    </div>
</div>
<!-- end : list 01 -->
<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Monthly Total Earnings
        <div class="number"><i class="fa fa-euro"></i>
            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($avgEarningAmount), 2) }}</div>
    </div>
</div>
<!-- end : list 01 -->
<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        ClassHub Commissions Received
        <div class="number"><i class="fa fa-euro"></i>
            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($commissionAmount), 2) }}</div>
    </div>
</div>
<!-- end : list 01 -->

<!-- starts : list 01 -->
{{--<div class="col-lg-6">
    <div class="list">
        Stripe Fees
        <div class="number"><i class="fa fa-euro"></i>
            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($stripeFee), 2) }}</div>
    </div>
</div>
<!-- end : list 01 -->
<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        Customer Service Charges
        <div class="number"><i class="fa fa-euro"></i>
            {{ number_format(\App\Helpers\ClassHubHelper::centToEuro($serviceCharge), 2) }}</div>
    </div>
</div>--}}
<!-- end : list 01 -->

<!-- starts : list 01 -->
<div class="col-lg-6">
    <div class="list">
        <a class="btn btn-brand" href="{{ route('page.download.monthly-stats') }}?date={{ $date }}"
           style="margin-top: 20px">Download Stats Report</a>
    </div>
</div>
<!-- end : list 01 -->
