<!--begin::cancel-class-confirmation Modal-->
<div class="modal fade c-modal v1 profile-has-been-updated" id="stripe-loading-modal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered {{ (new \Jenssegers\Agent\Agent())->isMobile() ? 'mobile-modal' : '' }}"
         style="{{ (new \Jenssegers\Agent\Agent())->isMobile() ? 'margin-top:-70px !important' : ''}}"
    role="document">
   <div class="modal-content">
       <div class="modal-header">
       </div>
       <div class="modal-body text-center" style="padding: 40px 30px 20px 30px;">
           <div class="spinner"></div>
           <div class="col-12 text-center" style="margin-top: 15px">
               <h3 style="font-weight: bold">Loading... Just a tic</h3>
           </div>
           <div class="col-12 text-right">
               <img src="{{ asset('img/stripe-loading.png') }}" style="max-width: 150px">
                </div>
            </div>
        </div>
    </div>
</div>
<!--end:: cancel-class-confirmation Modal-->
