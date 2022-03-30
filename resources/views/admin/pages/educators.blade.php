@extends('admin.layouts.master')

@section('title')
    Classhub | Providers
@endsection

@section('page_styles')
    <style type="text/css">
        .new-references {
            background: #e74a65 !important;
        }

        .new-references i {
            color: #fff !important;
        }
    </style>
@endsection

@section('content')

    <div class="m-content">
        <!--Begin::Section-->
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Providers
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="datatable">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Live Classes
                        </th>
                        <th>
                            Date Joined
                        </th>
                        <th>
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>


        <!--begin::Modal-->
        <div class="modal fade" id="fees" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>

        <div class="modal fade" id="references" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Provider References
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            											<span aria-hidden="true">
            												&times;
            											</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                </div>
            </div>
        </div>
        <!--End::Section-->


    </div>

@endsection


@section('page_scripts')
    <script src="{{ asset('admin/js/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admin/js/moment.js') }}" type="text/javascript"></script>

    <script type="text/javascript">

        var initDataTable = {
            init: function () {
                var t;

                $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
                });

                $("#export_print").on("click", function (e) {
                        e.preventDefault(), t.button(0).trigger()
                    }
                ),
                    $("#export_copy").on("click", function (e) {
                            e.preventDefault(), t.button(1).trigger()
                        }
                    ),

                    $("#export_excel").on("click", function (e) {
                            e.preventDefault(), t.button(2).trigger()
                        }
                    ),

                    $("#export_csv").on("click", function (e) {
                            e.preventDefault(), t.button(3).trigger()
                        }
                    ),

                    $("#export_pdf").on("click", function (e) {
                            e.preventDefault(), t.button(4).trigger()
                        }
                    )
            }
        };

        $(function () {
            initDataTable.init();

            var dataTable = $("#datatable").DataTable({
                serverSide: true,
                processing: true,
                errMode: 'throw',
                searchDelay: 500,
                ajax: {
                    url: '{{ route('admin.educators.datatable') }}',
                    type: 'POST',
                    data: function (d) {
                        d._token = '{{ csrf_token() }}';
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'classes', name: 'classes', sortable: false},
                    {data: 'date_joined', name: 'date_joined', sortable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [],
                responsive: !0,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],

            })

            $('body').on('click', 'a.delete-account', function () {
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to delete this providers account?',
                    text: 'All of their information and classes will be deleted too',
                    type: 'error',
                    showCancelButton: !0,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            swal({
                                title: 'Deleting provider.. Please wait',
                                type: 'info',
                                showCancelButton: false,
                                showConfirmButton: false
                            })

                            $.ajax({
                                type: 'DELETE',
                                url: $(_this).data('route'),
                                data: {_token: '{{ csrf_token() }}'},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        swal('Provider Deleted!', '', "success")
                                        dataTable.draw()
                                    } else {
                                        swal('Error', data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal('Error', data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })

            $('body').on('click', 'a.trusted', function () {
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to ' + $(_this).attr('title') + '?',
                    type: 'info',
                    showCancelButton: !0,
                    confirmButtonText: $(_this).attr('title'),
                    cancelButtonText: 'Cancel',
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            swal({
                                title: $(_this).attr('title') + '.. Please wait',
                                type: 'info',
                                showCancelButton: false,
                                showConfirmButton: false
                            })

                            $.ajax({
                                type: 'POST',
                                url: '{{ route('admin.toggle.trusted') }}',
                                data: {_token: '{{ csrf_token() }}', user_id: $(_this).data('user-id')},
                                dataType: 'JSON',
                                success: function (data) {
                                    console.log(data)
                                    if (data.status) {
                                        swal(data.messages.join(), '', "success")
                                        dataTable.draw()
                                    } else {
                                        swal('Error', data.messages.join(), "error")
                                    }
                                },
                                error: function (data) {
                                    swal('Error', data.messages.join(), "error")
                                }
                            })
                        } else {
                            "cancel" === e.dismiss
                        }
                    })
            })

            // get edit lesson modal
            $('body').on('click', 'a.edit-fees', function () {
                $('div#fees div.modal-content').html('<div class="m-loader m-loader--brand"></div>')

                $.ajax({
                    type: 'GET',
                    url: $(this).data('route'),
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'HTML',
                    success: function (data) {
                        $('div#fees div.modal-content').html(data)
                    },
                    error: function (data) {
                        $('div#fees div.modal-content').html(data)
                    }
                })
            })

            // get references modal
            $('body').on('click', 'a.references', function () {
                $('div#fees div.modal-content').html('<div class="m-loader m-loader--brand"></div>')

                $.ajax({
                    type: 'GET',
                    url: $(this).data('route'),
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'HTML',
                    success: function (data) {
                        $('div#references div.modal-body').html(data)
                    },
                    error: function (data) {
                        $('div#references div.modal-body').html(data)
                    }
                })
            })

            // Update Educator fees
            $('body').on('click', 'button.update-fees', function () {
                var dataString = $('form#provider-fees-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: $(this).data('route'),
                    data: dataString,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                            $('div#fees').modal('hide')
                            swal('Success', data.messages.join(), "success")
                        } else {
                            swal('Error', data.messages.join(), "error")
                        }
                    },
                    error: function (data) {
                        swal('Error', data.messages.join(), "error")

                    }
                })
            })


            // Accept references
            $('body').on('click', 'button.accept-references', function () {
                $.ajax({
                    type: 'POST',
                    url: $(this).data('route'),
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.status) {
                            $('div#references').modal('hide')
                            swal('Success', data.messages.join(), "success")
                        } else {
                            swal('Error', data.messages.join(), "error")
                        }
                    },
                    error: function (data) {
                        swal('Error', data.messages.join(), "error")
                    }
                })
            })

            // Clear fee modal on hidden
            $('div#fees').on('hide.bs.modal', function () {
                $(this).find('div.modal-content').html('')
            })


        })


    </script>
@endsection

