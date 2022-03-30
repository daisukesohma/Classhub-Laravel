<div class="list-a-class">

    <div class="text-center">
        <div class="title fs-30 fw-5 p-l-0">Payment summary</div>
        <div class="sub-title fw-5 p-t-5 p-b-25">{{ $lesson->name }}</div>
    </div>

    <!-- starts: Price row -->
    <div class="form-group m-form__group class-price">
        <div class="">
            <div class="input-group m-input-group shadow-v2 border-r-6">
                <div class="input-group-prepend">
                    <span class="input-group-text">€</span>
                </div>
                <input type="text" readonly style="border-radius: 0"
                       class="form-control m-input"
                       value="{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($totalAmount), 2) }}"
                />
            </div>
        </div>
    </div>
    <!-- end: Price row -->

    <!-- starts : table data -->
    <table class="table">
        <tbody>
        <tr>
            <td>
                €{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($lesson->price), 2) }}
                {{ $lesson->type === 'single' || $lesson->type === 'subject' ? count($classes).' x classes' :
                    '('.ucwords($lesson->type).' : '.count($classes).' classes)' }}
            </td>
            <td>€{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($price), 2) }}</td>
        </tr>
        <tr>
            <td>Service charge</td>
            <td>€{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($serviceChargeAmount), 2) }}</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>€{{ number_format(\App\Helpers\ClassHubHelper::centToEuro($totalAmount), 2) }}</td>
        </tr>
        </tbody>
    </table>
    <!-- end : table data -->


    <!-- starts : table data -->
    @if($cards->count())
        <table class="table">
            <tbody>
            @foreach($cards as $card)
                <tr>
                    <td>**** **** **** {{ $card->last4 }}</td>
                    <td>{{ strtoupper($card->brand) }}</td>
                    <td>
                        <a href="javascript:;" class="use-existing-card"
                           data-card-id="{{ $card->card_id }}"
                           data-card-last4="{{ $card->last4 }}"
                           data-card-country="{{ $card->country }}"
                           data-toggle="modal" data-target="#confirm-card-modal"
                           data-dismiss="modal">Use Card</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
@endif
<!-- end : table data -->


    <!-- starts : payment form -->
    <div class="payment-form">

        <form class="m-form m-form--label-align-left- m-form--state-"
              action="{{ route('book.lesson') }}" method="post" id="payment-form">
        {!!  csrf_field() !!}

        {!!  Form::hidden('lesson_id', $lesson->id) !!}

        {!!  Form::hidden('class_ids', implode(',', $classes)) !!}

        {!!  Form::hidden('message_id', $messageId) !!}

        <!--begin: Form Wizard-->
            <div class="m-wizard__form">

                <!--begin: Form Body -->
                <div class="m-portlet__body" id="card-element">
                    <div class="form-group m-form__group row">
                        <img class="stripe-logo-payments" src="/img/stripe-logos/solid-dark/powered_by_stripe@3x.png"
                             alt="powered by stripe badge"/>
                    </div>
                    <!-- starts : row : Name on Card -->
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            <input type="text" name="card_holder_name" class="form-control m-input"
                                   placeholder="Name on Card" value="">
                        </div>
                    </div>
                    <!-- end : row : Name on Card -->

                    <!-- starts : row : Card Number -->
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            <div class="form-control m-input" id="card-number-element"></div>
                        </div>
                    </div>
                    <!-- end : row : Card Number -->

                    <!-- starts : row : Expiry Date -->
                    <div class="form-group m-form__group row two-selectboxes">
                        {{--<div class="col-lg-3 m-form__group-sub fw-5 p-t-12">
                            Expiry Date
                        </div>--}}
                        <div class="col-lg-6 m-form__group-sub two">
                            <div class="form-control m-input" id="card-expiry-element"></div>
                        </div>

                        <div class="col-lg-6 m-form__group-sub two">
                            <div class="form-control m-input" id="card-cvc-element"></div>
                        </div>
                    </div>
                    <!-- ends : row : Expiry Date -->

                    <div class="form-group m-form__group row">
                        <div class="col-lg-12">
                            <label for="student_name">Add the students name who will be attending this booking.</label>
                            <input type="text" name="student_name" class="form-control m-input"
                                   placeholder="Student Name" value="" required>
                        </div>
                    </div>
                    <div class="fs-14">I agree to the <a href="{{ route('page.terms-conditions')}}" target="_blank">Cancelation
                            & Refund Policy</a>. To
                        see our Service Charge structure <a href="{{ route('page.terms-conditions')}}" target="_blank">click
                            here</a>.
                    </div>

                    <!-- starts : Confirm and pay button -->
                    <div class="text-center p-t-15">
                        <button type="submit" class="btn btn-primary shadow-v4" disabled id="book-lesson"><span
                                class="btn__text">Confirm and pay</span></button>
                    </div>
                    <!-- end : Confirm and pay button -->
                    <div id="errors" style="color: red; text-align: center">

                    </div>

                </div>
                <!--end: Form Body-->
            </div>
            <!--end: Form Wizard-->
        </form>

    </div>
    <!-- end : payment form -->

</div>

<script type="text/javascript">

    var paymentModal = $('div#payment-summary')
    var bookingConfirmedModal = $('div#booking-confirmed-modal')
    var bookBtn = $('button#book-lesson')
    var errorElement = document.getElementById('errors')
    var cardId = ''
    var cardCountry = ''
    var studentName = ''

    var stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}');
    var elements = stripe.elements();

    var style = {
        base: {
            fontSize: '18px',
            color: '#1F323D',
            fontWeight: 400
        },
    };

    // Create an instance of the card Elements.
    var cardNumberElement = elements.create('cardNumber', {style: style, placeholder: 'Card Number'});
    cardNumberElement.mount('#card-number-element');

    var cardExpiryElement = elements.create('cardExpiry', {style: style});
    cardExpiryElement.mount('#card-expiry-element');

    var cardCvcElement = elements.create('cardCvc', {style: style});
    cardCvcElement.mount('#card-cvc-element');

    // Handle real-time validation errors from the card Element.
    var cardElements = [cardNumberElement, cardExpiryElement, cardCvcElement];
    for (var i = 0; i < cardElements.length; i++) {
        cardElements[i].addEventListener('change', function (event) {
            if (event.error) {
                $(errorElement).html(event.error.message)
                $(bookBtn).attr('disabled', true)
            } else {
                $(errorElement).html('');
                $(bookBtn).attr('disabled', false)
            }
        })
    }

    // Handle form submission.
    var form = document.getElementById('payment-form');

    form.addEventListener('submit', function (event) {

        $(bookBtn).attr('disabled', true)

        var cardHolderName = $('input[name="card_holder_name"]').val()
        studentName = $('input[name="student_name"]').val()

        event.preventDefault();

        stripe.createPaymentMethod('card', cardNumberElement, {
            billing_details: {
                name: cardHolderName
            }
        }).then(function (result) {
            if (result.error) {
                $(errorElement).html(result.error.message);
                $(bookBtn).attr('disabled', false)
            } else {
                $(paymentModal).modal('hide');
                $(resultModal).find('div.modal-body')
                    .append('<p>Processing payment.. Please do not close or reload page.</p>');
                $(resultModal).modal('show');
                console.log(result.paymentMethod.id)
                cardCountry = result.paymentMethod.card.country

                fetch('{{ route('book.lesson') }}', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(
                        {
                            _token: '{{ csrf_token() }}',
                            lesson_id: $('input[name="lesson_id"]').val(),
                            class_ids: $('input[name="class_ids"]').val(),
                            message_id: $('input[name="message_id"]').val(),
                            student_name: studentName,
                            payment_method_id: result.paymentMethod.id,
                            card_country: cardCountry
                        }
                    )
                }).then(function (result) {
                    console.log('PM result', result)
                    result.json().then(function (json) {
                        handleServerResponse(json);
                    })
                });
            }
        })
    });


    $('body').on('click', 'a.pay-card-btn', function () {

        $(resultModal).find('div.modal-body')
            .append('<p>Processing payment.. Please do not close or reload page.</p>');

        studentName = $('input[name="card_student_name"]').val();

        fetch('{{ route('book.lesson') }}', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(
                {
                    _token: '{{ csrf_token() }}',
                    lesson_id: $('input[name="lesson_id"]').val(),
                    class_ids: $('input[name="class_ids"]').val(),
                    message_id: $('input[name="message_id"]').val(),
                    student_name: studentName,
                    payment_method_id: cardId,
                    customer: '{{ Auth::user()->stripe_cust_id }}',
                    card_country: cardCountry,
                }
            )
        }).then(function (result) {
            console.log('PM result', result)
            result.json().then(function (json) {
                handleServerResponse(json);
            })
        });

    })

    function handleServerResponse(response) {

        if (response.status == false) {
            // Show error from server on payment form
            console.log('server response error 1', response)
            $(resultModal).find('div.modal-body').html(response.messages.join('<br>'))
            $(bookBtn).attr('disabled', false)
            $('div.modal-backdrop.fade.show').css('display', 'none').attr('class', '')
        } else if (response.requires_action) {

            stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}', {
                stripeAccount: response.connect_account_id
            });

            // Use Stripe.js to handle required card action
            stripe.handleCardAction(
                response.payment_intent_client_secret
            ).then(function (result) {
                console.log('Handle Card Action result', result)

                if (result.error) {
                    console.log('server response error 2', result)
                    // Show error from server on payment form
                    $(resultModal).find('div.modal-body').html(result.error.message)
                    $('div.modal-backdrop.fade.show').css('display', 'none').attr('class', '')
                } else {
                    // The card action has been handled
                    // The PaymentIntent can be confirmed again on the server
                    fetch('{{ route('book.lesson') }}', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json'},
                        body: JSON.stringify(
                            {
                                _token: '{{ csrf_token() }}',
                                lesson_id: $('input[name="lesson_id"]').val(),
                                class_ids: $('input[name="class_ids"]').val(),
                                message_id: $('input[name="message_id"]').val(),
                                student_name: studentName,
                                payment_intent_id: result.paymentIntent.id,
                                stripeAccount: result.connect_account_id,
                                card_country: cardCountry
                            }
                        )
                    }).then(function (confirmResult) {
                        console.log('Confirm', confirmResult)
                        return confirmResult.json()

                    }).then(handleServerResponse);
                }
            });
        } else {
            $(resultModal).modal('hide')
            $('div.modal-backdrop.fade.show').css('display', 'none').attr('class', '')
            $(bookingConfirmedModal).modal('show')

            window.dataLayer.push({
                'event': 'class_booking',
                'transactionId': response.data.booking.id,
                'transactionTotal': response.data.booking.amount / 100,
                'transactionApplicationFee': response.data.booking.application_fee / 100,
                'transactionProducts': [{
                    'sku': response.data.booking.code,
                    'name': response.data.lesson.name,
                    'price': response.data.lesson.price / 100,
                    'quantity': response.data.qty
                }]
            });

            /*setTimeout(function () {
                window.location = '{{ route('parent.dashboard') }}'
            }, 3000)*/
        }
    }

    $('body').on('click', 'a.use-existing-card', function () {
        cardId = $(this).data('card-id');
        cardCountry = $(this).data('card-country');
        $('div#confirm-card-modal span#last4').html($(this).data('card-last4'))
    })

    $(bookingConfirmedModal).on('hidden.bs.modal', function () {
        window.location = '{{ route('parent.dashboard') }}'
    })

</script>
