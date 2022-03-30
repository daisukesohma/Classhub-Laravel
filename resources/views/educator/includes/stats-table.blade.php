<div class="earning-table dashboard-right-table">
  <div class="row title-add-button">
      <div class="col-6">
          <h4 class="dashboard-header">Overview</h4>
      </div>

  </div>
    <table class="table">
        <thead>
        <tr id="year-earning">
            <th>{{ date('Y') }} Earnings</th>
            <th>
                <i class="la la-chevron-circle-left prev-stat stat-earning"
                   data-value="{{ \Carbon\Carbon::now()->subYear()->format('Y') }}"
                   data-type="year"></i>
                <i class="la la-chevron-circle-right next-stat stat-earning"
                   data-value="{{ \Carbon\Carbon::now()->addYear()->format('Y') }}"
                   data-type="year"></i>
            </th>
            <th>€{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($currentYearEarnAmount), 2) }}</th>
        </tr>
        </thead>
        <tbody>
        <!-- starts: list 01 -->
        <tr id="month-earning">
            <td>{{ date('F Y') }} Earnings</td>
            <td>
                <i class="la la-chevron-circle-left prev-stat stat-earning"
                   data-value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m') }}"
                   data-type="month"></i>
                <i class="la la-chevron-circle-right next-stat stat-earning"
                   data-value="{{ \Carbon\Carbon::now()->addMonth()->format('Y-m') }}"
                   data-type="month"></i>
            </td>
            <td>€{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($currentMonthEarnAmount), 2) }}</td>
        </tr>
        <!-- end: list 01 -->
        <!-- starts: list 02 -->
        <tr id="ads-view">
            <td>{{ date('F Y') }} Ad Views</td>
            <td>
                <i class="la la-chevron-circle-left prev-stat stat-ad-view"
                   data-value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m') }}"
                   data-type="month"></i>
                <i class="la la-chevron-circle-right next-stat stat-ad-view"
                   data-value="{{ \Carbon\Carbon::now()->addMonth()->format('Y-m') }}"
                   data-type="month"></i>
            </td>
            <td>{{ $adViews }}</td>
        </tr>
        <!-- end: list 02 -->
        <!-- starts: list 03 -->
        <tr id="booking-count">
            <td>{{ date('F Y') }} Bookings</td>
            <td>
                <i class="la la-chevron-circle-left prev-stat stat-booking"
                   data-value="{{ \Carbon\Carbon::now()->subMonth()->format('Y-m') }}"
                   data-type="month"></i>
                <i class="la la-chevron-circle-right next-stat stat-booking"
                   data-value="{{ \Carbon\Carbon::now()->addMonth()->format('Y-m') }}"
                   data-type="month"></i> </td>
            <td>{{ $numBookings }}</td>
        </tr>
        <!-- end: list 03 -->
        </tbody>
    </table>
    <!-- starts : get stats link -->
    <div class="text-right status-link">
        <a href="{{ route('educator.stats') }}" class="link-01 fw-5">Get stats report?</a>
    </div>
    <!-- end : get stats link -->


</div>

<div class="row">
    @if(!Auth::user()->trusted)
        <div class="col-lg-12 col-md-6 col-md-eq-height col-xs-ps-0">
            <!-- starts : Trusted Section  -->
            <div class="profile-side-nav">
                <div class="m-portlet trusted-box">
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col-md-1 col-sm-2 col-xs-3">
                                <img class="trusted-shield"
                                     src="/img/trusted-by/list-a-class/batch.png"/>
                            </div>
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <h4 style="font-weight: bold">Become Trusted</h4>
                                <p style="font-size: 14px;">When you're become Trusted tutor. you are more likely to get more students.<br>All you need to do is to confirm your identity with us</p>

                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <span class="subtitle"><a style="color: #E7AB4B; font-weight: bold"
                                        href="{{ route('educator.trusted') }}">Become Trusted</a></span>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
            <!-- end : Trusted Section  -->
            <!-- end : Dashboard Nav -->
        </div>
    @endif
</div>
