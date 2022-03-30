var SweetAlert2Demo = {
    init: function() {
        $(".delete-account").click(function(e) {
            swal({
                title: "Are you sure you want to delete this providers account?",
                text: "All of their information and classes will be deleted too",
                type: "error",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete",
                cancelButtonText: "No, cancel",
                reverseButtons: !0
            }).then(function(e) {
                e.value ? swal("Provider Deleted!", "This provider has been deleted.", "success") : "cancel" === e.dismiss
            })
        }),
        $("#edit-fees").click(function(e) {
            swal({
                title: "Are you sure you want to change the Global Fees?",
                text: "This will affect every providers fees unless they have been changed for that specific provider.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, update them",
                cancelButtonText: "No, cancel",
                reverseButtons: !0
            }).then(function(e) {
                e.value ? swal("Fees updated", "", "success") : "cancel" === e.dismiss
            })
        })
    }
};
jQuery(document).ready(function() {
    SweetAlert2Demo.init()
});
