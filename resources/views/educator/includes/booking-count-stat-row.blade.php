<td>{{ $date->format('F Y')  }} Bookings</td>
<td>
    <i class="la la-chevron-circle-left prev-stat stat-booking"
       data-value="{{ $date->subMonth()->format('Y-m') }}"
       data-type="month"></i>
    <i class="la la-chevron-circle-right next-stat stat-booking"
       data-value="{{ $date->addMonths(2)->format('Y-m') }}"
       data-type="month"></i>
</td>
<td>{{ $numBookings }}</td>
