@if(env('APP_ENV') == 'production')
    <!-- CookiePro Cookies Consent Notice start -->
    <script src="https://cookie-cdn.cookiepro.com/consent/96d7de76-ac7b-498f-adf1-8762483f024c.js" type="text/javascript" charset="UTF-8"></script>

    <script type="text/javascript">
        function OptanonWrapper(stuff) {
            $("button.cookie-settings-button").attr("style", "color: #E74B65 !important");
         }
    </script>
    <!-- CookiePro Cookies Consent Notice end -->
@else
    <script src="https://cookiepro.blob.core.windows.net/consent/85f48324-8b77-4af4-a7e1-a25a5fbbaab1-test.js" type="text/javascript" charset="UTF-8"></script>

    <script type="text/javascript">
        function OptanonWrapper() {
          $("button.cookie-settings-button").attr("style", "color: #E74B65 !important")
         }
    </script>
@endif
