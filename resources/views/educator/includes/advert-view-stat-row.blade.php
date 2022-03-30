<td>{{ $date->format('F Y')  }} Ad Views</td>
<td>
    <i class="la la-chevron-circle-left prev-stat stat-ad-view"
       data-value="{{ $date->subMonth()->format('Y-m') }}"
       data-type="month"></i>
    <i class="la la-chevron-circle-right next-stat stat-ad-view"
       data-value="{{ $date->addMonths(2)->format('Y-m') }}"
       data-type="month"></i>
</td>
<td>{{ $adViews }}</td>
