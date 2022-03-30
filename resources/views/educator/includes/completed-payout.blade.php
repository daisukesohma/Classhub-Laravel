<div class="col-12">
    <strong>Paid out: {{ $currencySymbol }}{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($total), 2) }}</strong>
</div>
<br>
<div class="m-accordion m-accordion--default" id="m_accordion_1"
     role="tablist">
    <?php $i = 1; ?>
    @foreach($completedPayouts as $completedPayout)

        <?php
        if ($completedPayout['total'] == 0)
            continue;
        ?>

        <div class="m-accordion__item" style="overflow: hidden !important">
            <div class="m-accordion__item-head class-type-select collapsed"
                 role="tab"
                 id="m_accordion_1_item_{{ $i }}_head" data-toggle="collapse"
                 href="#m_accordion_1_item_{{ $i }}_body"
                 aria-expanded="    false">

                <span class="title text-left lesson-class-name">{{ $completedPayout['lesson_name'] }}</span>
                <span class="title text-right lesson-amount" style="float: right">
                        <strong>{{ $completedPayout['currency_symbol'] }}{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($completedPayout['total']), 2) }}</strong>
                    <span class="expand-arrow" style="padding-left: 10px"><i class="fa fa-chevron-down"></i></span>
                    </span>

            </div>

            <div class="m-accordion__item-body collapse term-of-classes"
                 id="m_accordion_1_item_{{ $i }}_body" class=" " role="tabpanel"
                 aria-labelledby="m_accordion_1_item_{{ $i }}_head"
                 data-parent="#m_accordion_1">
                <div class="m-accordion__item-content">

                    <!--begin::Form-->
                    <div class="m-portlet__body">
                        @foreach($completedPayout['classes'] as $class)
                            <?php
                            if (!isset($class['bookings']))
                                continue;
                            ?>
                            <table class="pending-payouts">
                                @if($completedPayout['type'] == 'single')
                                <tr>
                                  <th class="text-center" style="padding-left: 10px"><strong>Class Date</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Time</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Class #</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Student</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Booking Reference</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Amount</strong></th>
                                </tr>
                                @else
                                <tr>
                                  <th class="text-center" style="padding-left: 10px"><strong>Class Date</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Time</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Class #</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Student</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Booking Reference</strong></th>
                                  <th class="text-center" style="padding-left: 10px"><strong>Amount</strong></th>
                                </tr>
                                @endif
                            @foreach($class['bookings'] as $booking)
                                @if($completedPayout['type'] == 'single')
                                <tr>
                                  <td class="text-center">{{ $class['class_date'] }}</td>
                                  <td class="text-center">{{ $booking['start_time'].' - '.$booking['end_time'] }}</td>
                                  <td class="text-center">{{ $booking['class_id']  }}</td>
                                  <td class="text-center">{{ $booking['student'] }}</td>
                                  <td class="text-center">{{ $booking['code'] }}</td>
                                  <td class="text-center">{{ $booking['currency_symbol'] }}{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($booking['amount']), 2) }}</td>
                                </tr>

                                    <tr style="margin-bottom: 10px; ">
                                        <th colspan="5" style="padding-left: 10px">Estimated Arrival {{ $booking['arrival_date'] }}</th>
                                    </tr>
                                @else
                                <tr>
                                  <td class="text-center">{{ $class['class_date'] }}</td>
                                  <td class="text-center">{{ $booking['start_time'].' - '.$booking['end_time'] }}</td>
                                  <td class="text-center">{{ $booking['class_id']  }}</td>
                                  <td class="text-center">{{ $booking['student'] }}</td>
                                  <td class="text-center">{{ $booking['code'] }}</td>
                                  <td class="text-center">{{ $booking['currency_symbol'] }}{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($booking['amount']), 2) }}</td>
                                </tr>
                                    <tr style="margin-bottom: 10px; ">
                                        <th colspan="5" style="padding-left: 10px">Estimated Arrival {{ $booking['arrival_date'] }}</th>

                                    </tr>
                                @endif
                            @endforeach
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; ?>
    @endforeach
</div>
