<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Mentoring</title>
    <base href="{{ asset('') }}" />
    <link type="image/x-icon" href="frontend/assets/img/favicon.png" rel="icon">

    <link rel="stylesheet" href="frontend/assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="frontend/assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="frontend/assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="frontend/assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="frontend/assets/plugins/daterangepicker/daterangepicker.css">

    <link rel="stylesheet" href="frontend/assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="frontend/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="frontend/assets/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="frontend/assets/css/style.css">
</head>






@include('layouts.frontend.header')

<div class="main-wrapper">

    @yield('content')


    @include('layouts.frontend.footer')

</div>

<script data-cfasync="false" src="frontend/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="frontend/assets/js/jquery-3.6.0.min.js"></script>

<script src="frontend/assets/js/popper.min.js"></script>
<script src="frontend/assets/js/bootstrap.bundle.min.js"></script>

<script src="frontend/assets/plugins/select2/js/select2.min.js"></script>

<script src="frontend/assets/js/moment.min.js"></script>
<script src="frontend/assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="frontend/assets/plugins/daterangepicker/daterangepicker.js"></script>

<script src="frontend/assets/js/owl.carousel.min.js"></script>

<script src="frontend/assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
<script src="frontend/assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>



<script src="frontend/assets/js/script.js"></script>
</body>

</html>
