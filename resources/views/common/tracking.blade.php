<script src="{{ asset('js/jquery.min.js') }}"></script>

<!-- Google Tag Manager -->
<script type="text/javascript" class="optanon-category-C0002">
    window.dataLayer = window.dataLayer || [];

    (function (w, d, s, l, i) {
        w[l] = w[l] || [];
        w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        });
        var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
        j.async = true;
        j.type = "text/plain"
        j.className = "optanon-category-C0002"
        j.src =
            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
        f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-WQJWH7R');
</script>
<!-- End Google Tag Manager  KQL89QB - WQJWH7R -->

@if(env('APP_ENV') == 'production')
    <!-- Hotjar Tracking Code for classhub.ie -->
    <!-- <script type="text/plain" class="optanon-category-C0002">
        (function (h, o, t, j, a, r) {
            h.hj = h.hj || function () {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {hjid: 1397783, hjsv: 6};
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script> -->

    <!-- Linkedin start -->
    <script type="text/plain" class="optanon-category-C0002">
        _linkedin_partner_id = "1303372";
        window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
        window._linkedin_data_partner_ids.push(_linkedin_partner_id);
    </script>
    <script type="text/plain" class="optanon-category-C0002">
        (function () {
            var s = document.getElementsByTagName("script")[0];
            var b = document.createElement("script");
            b.type = "text/javascript";
            b.async = true;
            b.type = "text/plain"
            b.className = "optanon-category-C0002"
            b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
            s.parentNode.insertBefore(b, s);
        })();
    </script>
    <!-- Linkedin end -->
@endif
