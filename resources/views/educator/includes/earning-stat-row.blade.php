<?php $openTag = $type == 'year' ? '<th>' : '<td>'; ?>
<?php $closeTag = $type == 'year' ? '</th>' : '</td>'; ?>
{!! $openTag !!}{{  $type == 'year' ? $date->format('Y') : $date->format('F Y') }} Earnings{!! $closeTag !!}
{!! $openTag !!}
<i class="la la-chevron-circle-left prev-stat stat-earning"
   data-value="{{ $type == 'year' ? $date->subYear()->format('Y') :
         $date->subMonth()->format('Y-m') }}"
   data-type="{{ $type }}"></i>
<i class="la la-chevron-circle-right next-stat stat-earning"
   data-value="{{ $type == 'year' ? $date->addYears(2)->format('Y') :
         $date->addMonths(2)->format('Y-m') }}"
   data-type="{{ $type }}"></i>
{!! $closeTag !!}
{!! $openTag !!}€{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($earningAmount), 2) }}{!! $closeTag !!}
