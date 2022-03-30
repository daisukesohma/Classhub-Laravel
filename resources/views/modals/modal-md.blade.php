<div class="modal fade show" id="modal-md-info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{--<h5 class="modal-title">
                    Information
                </h5>--}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            											<span aria-hidden="true">
            												×
            											</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
                </button>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var modalInfoMd = $('#modal-md-info')

    modalInfoMd.on('hidden.bs.modal', function (e) {
        $(this).find('div.modal-body').html('')
    })
</script>

