@extends('educator.layouts.master')

@section('title')
    Classhub | Educator Dashboard
@endsection


@section('page_style')
<style>

.copy-link:hover {
  border: none!important;
  background: none!important;
}

</style>

@endsection

@section('content')

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper m-b-6">

            <div class="row col-12">

                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0 auto;">
                    <div class="m-content page-dashboard initial-dash">

                        <div class="row title-share">
                            <div class="col-xl-6">
                                <h3 class="m-form__heading-title" style="padding-bottom: 20px">Your Tutor Dashboard</h3>
                            </div>
                            {{--<div class="col-xl-6">
                                <!-- starts: share link + overlay -->
                                <div class="share-this">
                                    <a href="javascript:void(0)"
                                       data-link="{{ route('page.educator', Auth::user()->slug) }}"
                                       data-toggle="modal" data-target="#share-profile-modal"
                                       class="link-01 icon-share copy-link">Share this profile</a>
                                    <span class="m-badge m-badge--brand m-badge--wide info-badge m-0"
                                          data-toggle="m-popover" data-html="true" data-placement="bottom"
                                          data-content="<p>Choose Days & Times</p> Add in the person's email that you want to share this with">i</span>
                                </div>
                                <!-- end: share link + overlay -->
                            </div>--}}
                        </div>
                        <div class="row">
                          <div class="col-xl-3 col-lg-4 padding-mobile-none-lr col-eq-height">

                            <!-- starts : Dashboard Nav  -->
                            <div class="profile-side-nav">
                                <div class="m-portlet">
                                    <div class="m-portlet__body">

                                        @include('educator.includes.left-menu', ['page' => 'trusted'])

                                    </div>
                                </div>

                            </div>
                            <!-- end : Dashboard Nav -->

                        </div>
                          <div class="col-xl-9 col-lg-8 padding-mobile-none-lr col-eq-height">
                            <!--starts: Trusted -->
                            <div class="classes-table dashboard-right-table trusted-portlet">

                              <div class="row title-add-button">
                                  <div class="col-lg-1 col-md-2 col-sm-4"><img class="img-sm-center"
                                                                               src="/img/icons/trust/verified.png"/></div>
                                  <div class="col-lg-10 col-md-10 col-sm-8">
                                      <h4 class="bold sm-center-text">Become Trusted</h4>
                                      <h5 class="sm-center-text xs-pb-30"
                                          style="font-family:Open Sans, Arial, sans-serif; color: #1F323D; opacity: .57; font-weight: 300; font-size: 19px">
                                          There are two options to achieving the trusted status on classhub</h5>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                      <br>
                                      <p class="center-xs">
                                          <strong>Option 1</strong> : Classhub offers to reimburse any teacher or activity provider to
                                          the value of €30 for a copy of a valid and recent identity check that has been carried out
                                          on them. Identity checks are provided by many organisations including
                                          <a target="_blank" href="http://www.checkback.ie/">www.checkback.ie</a>. Once you have
                                          received your identity check send a copy to <a
                                              href="mailto:trust@classhub.ie">trust@classhub.ie</a> and we will upgrade your profile.
                                      </p>
                                      <br>
                                      <p class="center-xs">
                                          <strong>Option 2</strong> : Provide classhub with two references, these references should
                                          be from previous tutoring clients or if you are new to tutoring they should be character
                                          references. You can upload your references
                                          <a href="javascript:;" data-target="#reference-upload" data-toggle="modal"
                                             data-dismiss="modal">
                                              here</a> or email them to
                                          <a href="mailto:trust@classhub.ie">trust@classhub.ie.</a> All references will need to
                                          include the referee’s name and contact details so that they can be verified. Once they have
                                          been approved classhub will upgrade your profile.
                                      </p>
                                  </div>
                                  <div class="col-md-5 col-sm-12">
                                      <img src="/img/icons/trust/non-trusted-profile.png" alt="Non trusted profile badge"/>
                                  </div>
                                  <div class="col-md-1 col-sm-12">
                                      <img class="img-sm-center right-trusted-arrow" src="/img/icons/trust/arrow-right.png"
                                           alt="right arrow" style="position: absolute; top: 50%"/>
                                  </div>
                                  <div class="col-md-5 col-sm-12">
                                      <img src="/img/icons/trust/trusted-profile.png" alt="trusted profile badge"/>
                                  </div>

                                  {{--<div class="col-md-11">
                                      <a class="sm-center-text" href="javascript:void(0);" data-toggle="modal"
                                         data-target="#trusted">See benefits of having a trusted badge on Classhub</a>
                                  </div>--}}
                              </div>
                            </div>
                        <!--end: Trusted -->
                        </div>
                      </div>
                      <!--begin::Modal-->
                      <div class="modal fade c-modal payment-summary crc-check see-benefits-verified-badge" id="see-benefits-verified-badge" tabindex="-1" role="dialog" aria-labelledby="payment summary" aria-hidden="true">
                      	<div class="modal-dialog modal-dialog-centered modal-lg1" role="document">
                      		<div class="modal-content">
                      			<div class="modal-header">
                      				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      					<span aria-hidden="true">
                      						&times;
                      					</span>
                      				</button>
                      			</div>
                      			<div class="modal-body">
                      				<!-- starts : body -->
                      				<div class="list-a-class">

                      					<div class="top-section">
                      						<div class="title p-l-0">Benefits of having a gold profile on Classhub</div>
                      					</div>

                      					<!-- starts : btm-section -->
                      					<div class="btm-section">

                      						<div class="m-scrollable" data-scrollable="true" data-max-height="500">

                      							<!-- starts : Section 01 -->
                                                  <dl>
                                                      <dt>HIGHER TRUSTWORTHINESS</dt>
                                                      <dd>Being verified and having a gold profile on Classhub increases your credibility. This symbol <img class="verified" src="{{ asset('img/icons/trust/verified.png') }}" /> means you are both important and relevant.</dd>
                                                  </dl>
                                                  <!-- end : Section 01 -->

                                                  <!-- starts : Section 02 -->
                                                  <dl>
                                                      <dt>Lorem ipsium</dt>
                                                      <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doeiufio smodt empor sit amet, consectetur adipiscing elit, sed do eiusm Sed ut perspici atis unde omnis iste natus error sit voluptatemacu sertul antium doloremque laudantium, totam rem aperiam, eaque ipsama quae ab illo inventore verita is et quasi architecto beatae vita e di cta sunt explicabo. Nemo enim ips am voluptatem quia vo luptas sitdol</dd>
                                                  </dl>
                                                  <!-- end : Section 02 -->

                                                  <!-- starts : Section 03 -->
                                                  <dl>
                                                      <dt>Lorem ipsium</dt>
                                                      <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doeiufio smodt empor sit amet, consectetur adipiscing elit, sed do eiusm Sed ut perspici atis unde omnis iste natus error sit voluptatemacu sertul antium doloremque laudantium, totam rem aperiam, eaque ipsama quae ab illo inventore verita is et quasi architecto beatae vita e di cta sunt explicabo. Nemo enim ips am voluptatem quia vo luptas sitdol</dd>
                                                  </dl>
                                                  <!-- end : Section 03 -->

                      						</div>

                      					</div>
                      					<!-- end : btm-section -->

                      				</div>
                      				<!-- end : body -->
                      			</div>
                      		</div>
                      	</div>
                      </div>
                      <!--end::Modal-->
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('page_scripts')
@include('educator.modals.share-profile')
@include('educator.modals.trusted')

    <script src="{{  asset('js/custom.js') }}"></script>
    <script>
    $('button.share-profile-btn').on('click', function () {
        $('div#share-profile-modal').modal('hide')
        $(resultModal).modal('show')
        var id = $(this).data('id')
        var route = $(this).data('share-route')

        $.ajax({
            type: 'POST',
            url: route,
            data: {
                _token: '{{ csrf_token() }}',
                share_email: $('input[name="share_email"]').val(),
                educator_id: id
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                if (data.status) {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                } else {
                    $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
                }
            },
            error: function (data) {
                $(resultModal).find('div.modal-body').html(data.messages.join('<br>'))
            }
        })
    })
    </script>
@endsection
