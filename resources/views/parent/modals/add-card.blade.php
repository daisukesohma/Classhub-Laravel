<div class="modal fade c-modal  add-card" id="add-card-modal" tabindex="-1" role="dialog"
     aria-labelledby="payment summary" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg1" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-title" style="margin-top: 0">
                <div class="text-center">
                    <div class="title fs-25 fw-5 p-l-0">Add New Card</div>
                </div>
            </div>
            <div class="modal-body">
                <div class="list-a-class">

                    <!-- starts : payment form -->
                    <div class="payment-form">

                        <form class="m-form m-form--label-align-left- m-form--state-"
                              action="{{ route('parent.add.card') }}" method="post" id="add-card-form">

                        {!!  csrf_field() !!}

                        <!--begin: Form Wizard-->
                            <div class="m-wizard__form">

                                <!--begin: Form Body -->
                                <div class="m-portlet__body" id="card-element">
                                    <div class="form-group m-form__group row">
                                      <img class="stripe-logo-payments" src="/img/stripe-logos/solid-dark/powered_by_stripe@3x.png" alt="powered by stripe badge" height="20px" />
                                    </div>
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
                                    <!-- starts : row : Expiry Date -->

                                    <div class="text-center">
                                        <button type="submit" class="btn shadow-v4 m-t-32" disabled
                                                id="add-card" style="height: auto;"><span
                                                class="btn__text">Add Card</span></button>
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
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">

    var addCardBtn = $('button#add-card')
    var errorElement = document.getElementById('errors')

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
                $(addCardBtn).attr('disabled', true)
            } else {
                $(errorElement).html('');
                $(addCardBtn).attr('disabled', false)
            }
        })
    }

    // Handle form submission.
    var form = document.getElementById('add-card-form');

    form.addEventListener('submit', function (event) {

        $(addCardBtn).attr('disabled', true)

        event.preventDefault();

        stripe.createToken(cardNumberElement).then(function (result) {

            if (result.error) {
                $(errorElement).html(result.error.message);
                $(addCardBtn).attr('disabled', false)
            } else {
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);

                form.appendChild(hiddenInput);

                $('div#add-card-modal').modal('hide')
                $(resultModal).modal('show');

                $.ajax({
                    type: 'POST',
                    url: $(form).attr('action'),
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function (data) {
                        console.log(data)
                        if (data.status) {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                            setTimeout(function () {
                                location.reload()
                            }, 2000)
                        } else {
                            $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                        }
                    },
                    error: function (data) {
                        $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                    }
                })
            }
        });

        return false;
    });

</script>
