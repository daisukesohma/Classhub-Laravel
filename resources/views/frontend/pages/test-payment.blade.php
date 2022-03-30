@extends('frontend.layouts.master')

@section('title')
    Supplier Payment - @parent
@endsection

@section('content')

    <section class="imageblock switchable feature-large height-100">

        <div class="container pos-vertical-center">
            <div class="row">

                {{--<input class="person-address form-control" id="test" type="text" >--}}

                <div class="col-lg-5 col-md-7">
                    {{--<p>You are only one <strong>STEP</strong> away from getting your profile listed and increasing your
                        <strong>LEADS!</strong>.
                        We ensure that your business is guaranteed a return on investment and for less than €1.60
                        per day (€{{ \App\Setting::get('subscription_price') }} per month including VAT) its guaranteed!
                        You can opt out at anytime, so why not
                        try it for a month and let us prove to you that Weddingsuppliers.ie will work for your business!
                    </p>--}}
                    {!! Form::open(['url' => route('stripe.post.topup'), 'method' => 'POST',
                        'id' => 'payment-form']) !!}

                    <div class="row">
                        {{--<div class="col-12">
                            <input type="text" name="name" placeholder="Name On Card" autocomplete="off">
                        </div>--}}

                        <div class="col-12">
                            <input type="text" name="stripe_account" placeholder="stripe_account" autocomplete="off">
                        </div>

                        <div class="col-12">
                            <div id="card-number-element" class="stripe-input-container form-control"></div>
                        </div>

                        <div class="col-6">
                            <div id="card-expiry-element" class="stripe-input-container form-control"></div>
                        </div>

                        <div class="col-6">
                            <div id="card-cvc-element" class="stripe-input-container form-control"></div>
                        </div>

<input type="submit" value="submit" class="form-control">
                        <div class="col-12">
                            <div id="card-errors" style="color: darkred;"></div>
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </section>

@endsection

@section('footer')

@endsection

@section('page_scripts')

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&type=cities">
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ env('STRIPE_PUBLIC_KEY') }}');
        var elements = stripe.elements();

        var cardNumberElement = elements.create('cardNumber');
        cardNumberElement.mount('#card-number-element');

        var cardExpiryElement = elements.create('cardExpiry');
        cardExpiryElement.mount('#card-expiry-element');

        var cardCvcElement = elements.create('cardCvc');
        cardCvcElement.mount('#card-cvc-element');

        var cardElements = [cardNumberElement, cardExpiryElement, cardCvcElement];
        for (var i = 0; i < cardElements.length; i++) {
            cardElements[i].addEventListener('change', function (event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            })
        }


        // Create a token or display an error when the form is submitted.
        var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            stripe.createToken(cardNumberElement).then(function (result) {
                if (result.error) {
                    // Inform the customer that there was an error.
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the token to your server.
                    console.log(result)

                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }


        function initAutoCompleteFields() {
            var autocompletes = []

            $('input.person-address').each(function (index) {
                let input = document.getElementById($(this).attr('id'))
                let autocomplete = new google.maps.places.Autocomplete(input)
                autocomplete.inputId = $(this).attr('id')
                autocomplete.addListener('place_changed', placeChanged)
                autocompletes.push(autocomplete)
            })

            console.log(autocompletes)
        }

        initAutoCompleteFields();


        function placeChanged() {

            let addressField = $(`input#${this.inputId}`)

            place = this.getPlace()

            place.address_components.forEach(function (address_component) {
                let type = address_component.types[0];

                if (type == "country") {
                    $(addressField).siblings('input.country').val(address_component.short_name);
                }

                if (type == "locality" || type == "postal_town") {
                    $(addressField).siblings('input.city').val(address_component.long_name);
                }
                else if (type == "administrative_area_level_1") {
                    $(addressField).siblings('input.state').val(address_component.long_name);
                }

                if (type == "postal_code") {
                    $(addressField).siblings('input.postal_code').val(address_component.long_name);
                }

                if (type == "street_number" || type == "street_address") {
                    $(addressField).siblings('input.line1').val(place.name + ' ' + address_component.long_name);
                }

                if (type == "route"  || type == "neighborhood" || type == "sublocality") {
                    $(addressField).siblings('input.line2').val(address_component.long_name);
                }

            });

        }


    </script>

    <style type="text/css">
        .stripe-input-container {
            height: 40px;
            padding: 11px 13px;
            background: #fcfcfc;
        }

        .coupon-invalid {
            color: red;
        }

        .coupon-valid {
            color: green;
        }
    </style>

@endsection
