<!--begin::Modal-->
<div class="modal fade c-modal " id="reference-upload" tabindex="-1" role="dialog" aria-labelledby="payment summary"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content trusted-modal">
            <div class="modal-header">
                <div class="title p-l-0"><h3>Upload Reference Files</h3></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">
						&times;
					</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- starts : body -->

                <div class="form-group m-form__group row photo-bio references">

                    <label class="col-form-label col-lg-4">
                        <span class="text-primary">*</span>
                        References:
                        <span class="m-badge m-badge--wide info-badge"
                              data-toggle="m-popover" data-html="true"
                              data-placement="bottom"
                              data-content="Simply add two references with contact details that you may have, if you are new to tutoring then character references will do">i</span>
                    </label>

                    <div class="col-lg-8">
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="m-dropzone dropzone"
                                     action="{{ route('upload.image', 'references') }}"
                                     id="dropzone-ref1">

                                    <div
                                        class="m-dropzone__msg dz-message needsclick">
                                        <div class="m-dropzone__msg-title">Drop your
                                            First reference file
                                            here or click to upload.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="m-dropzone dropzone"
                                     action="{{ route('upload.image', 'references') }}"
                                     id="dropzone-ref2">
                                    <div
                                        class="m-dropzone__msg dz-message needsclick">
                                        <div class="m-dropzone__msg-title">Drop
                                            Second reference file
                                            here or click to upload.
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="save-continue text-right">
                    <a href="javascript:;" class="btn btn-primary shadow-v4" id="upload-file">
                        <span class="btn__text icon-arrow-right">SEND FILES</span></a>
                </div>

                <!-- end : body -->
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

<script type="text/javascript">
    $(function () {

        $('a#upload-file').on('click', function () {
            var ref1 = parseInt($('input[name="reference1"]').val())
            var ref2 = parseInt($('input[name="reference2"]').val())

            if (isNaN(ref1)) {
                alert('Reference file 1 upload error')
            }
            else if (isNaN(ref2)) {
                alert('Reference file 2 upload error')
            }
            else {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('educator.references.upload') }}',
                    data: {_token: '{{ csrf_token() }}', reference1: ref1, reference2: ref2},
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            $('#reference-upload').modal('hide')
                            $(resultModal).find('div.modal-body')
                                .html(data.messages.join('<br>'))
                            $(resultModal).modal('show')
                        } else {
                            $(resultModal).find('div.modal-body')
                                .html(data.messages.join('<br>'))
                            $(resultModal).modal('show')
                        }
                    },
                    error: function (data) {
                        $('#reference-upload').modal('hide')
                        $(resultModal).find('div.modal-body')
                            .html(data.messages.join('<br>'))
                        $(resultModal).modal('show')
                    }
                })
            }

        })


    });

    Dropzone.options.dropzoneRef1 = {
        addRemoveLinks: true,
        dictRemoveFile: 'Remove File',
        maxFiles: 1,
        removedfile: function (file) {
            var route = '{{ route('home') }}' + '/image/' + file.id + '/delete'

            $.ajax({
                type: 'DELETE',
                url: route,
                data: {_token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                },
                error: function (data) {
                    console.log(data)
                }
            });

            var _ref;
            return (_ref = file.previewElement) != null ?
                _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function (file, done) {
            if (done.error) {
                alert(done.error)
            } else {
                let formInput = Dropzone.createElement('<input type="hidden"  name="reference1"  ' +
                    'value="' + done.id + '">');
                file.previewElement.appendChild(formInput);
                file.id = done.id;
                file.path = done.path;
            }
        },
    }

    Dropzone.options.dropzoneRef2 = {
        addRemoveLinks: true,
        dictRemoveFile: 'Remove File',
        maxFiles: 1,
        removedfile: function (file) {
            var route = '{{ route('home') }}' + '/image/' + file.id + '/delete'

            $.ajax({
                type: 'DELETE',
                url: route,
                data: {_token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (data) {
                    console.log(data)
                },
                error: function (data) {
                    console.log(data)
                }
            });

            var _ref;
            return (_ref = file.previewElement) != null ?
                _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        success: function (file, done) {
            if (done.error) {
                alert(done.error)
            } else {
                let formInput = Dropzone.createElement('<input type="hidden"  name="reference2"  ' +
                    'value="' + done.id + '">');
                file.previewElement.appendChild(formInput);
                file.id = done.id;
                file.path = done.path;
            }
        },
    }

</script>
