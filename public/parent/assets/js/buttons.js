var DatatablesExtensionButtons= {
    init:function() {
        var t;
		$('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    } );
        $("#properties").DataTable( {
            responsive:!0, order:[[2, "desc"]], dom:"<'row'<'col-sm-6 text-left'f>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>", buttons:["print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5"], columnDefs:[ {
                targets:2, render:function(t, e, a, n) {
                    var s= {
                        1: {
                            title: "Occupied", class: "m-badge--success"
                        }, 2: {
                            title: "Vacant", class: " m-badge--danger"
                        }
                    }; return void 0===s[t]?t:'<span class="m-badge '+s[t].class+' m-badge--wide">'+s[t].title+"</span>";
                }
			}]
                }
        ),
        $("#export_print").on("click", function(e) {
            e.preventDefault(), t.button(0).trigger()
        }
        ),
        $("#export_copy").on("click", function(e) {
            e.preventDefault(), t.button(1).trigger()
        }
        ),
        $("#export_excel").on("click", function(e) {
            e.preventDefault(), t.button(2).trigger()
        }
        ),
        $("#export_csv").on("click", function(e) {
            e.preventDefault(), t.button(3).trigger()
        }
        ),
        $("#export_pdf").on("click", function(e) {
            e.preventDefault(), t.button(4).trigger()
        }
        )
    }
}

;
jQuery(document).ready(function() {
    DatatablesExtensionButtons.init()
}

);