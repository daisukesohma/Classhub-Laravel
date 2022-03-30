@if(Auth::user() && !Auth::user()->is_admin)
    <script type="text/javascript">
        $(function () {
            setInterval(function () {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('user.inbox.unread') }}',
                    data: {_token: '{{ csrf_token() }}'},
                    dataType: 'html',
                    success: function (data) {
                        if (data.status) {
                            $('.unread-counter').html(`<span
                                            class="m-badge m-badge--brand m-badge--wide top-margin "
                                            style="margin-top: 15px;">${data.unread}</span>`)
                        } else {
                            console.log(data)
                        }
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });
            }, 30000)
        })
    </script>
@endif
