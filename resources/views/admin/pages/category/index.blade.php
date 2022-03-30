@extends('admin.layouts.master')

@section('title')
    Classhub | Categories
@endsection

@section('content')

    <div class="m-content">

    @include('messages.all')

    <!--Begin::Section-->
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Categories
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="{{ route('admin.category.create') }}"
                               class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air">
												<span>
													<span>
														Add Category
													</span>
												</span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item"></li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable admin-category-table" id="datatable">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Sub-Categories
                        </th>
                        <th>
                            Cycle
                        </th>
                        <th>
                            Level
                        </th>
                        <th>
                            Date Added
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
        <div class="modal fade" id="edit-advert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                </div>
            </div>
        </div>
        <!--end::Modal-->
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
                    url: '{{ route('admin.categories.datatable') }}',
                    type: 'POST',
                    data: function (d) {
                        d._token = '{{ csrf_token() }}';
                    }
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
                    {data: 'sub_categories', name: 'sub_categories', sortable: false},
                    {data: 'cycle', name: 'cycle', sortable: false},
                    {data: 'level', name: 'level', sortable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [],
                responsive: !0,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                buttons: ["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"],

            })

            $('body').on('click', 'a.delete-category', function () {
                var _this = $(this)

                swal({
                    title: 'Are you sure you want to delete this Category?',
                    text: '(Sub-categories will also get deleted for Top Level Category)',
                    type: 'error',
                    showCancelButton: !0,
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: !0
                })
                    .then(function (e) {
                        if (e.value) {
                            swal({
                                title: 'Deleting Category.. Please wait',
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
                                        swal('Category Deleted!', '', "success")
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

        })


    </script>
@endsection

