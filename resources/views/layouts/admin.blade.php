<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Pignose Calender -->
    <link href="/assets/admin/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="/assets/admin/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="/assets/admin/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="/assets/admin/css/style.css" rel="stylesheet">

</head>

<body>
    @yield('body')

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="/assets/admin/plugins/common/common.min.js"></script>
    <script src="/assets/admin/js/custom.min.js"></script>
    <script src="/assets/admin/js/settings.js"></script>
    <script src="/assets/admin/js/gleek.js"></script>
    <script src="/assets/admin/js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="/assets/admin/plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="/assets/admin/plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="/assets/admin/plugins/d3v3/index.js"></script>
    <script src="/assets/admin/plugins/topojson/topojson.min.js"></script>
    <script src="/assets/admin/plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="/assets/admin/plugins/raphael/raphael.min.js"></script>
    <script src="/assets/admin/plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="/assets/admin/plugins/moment/moment.min.js"></script>
    <script src="/assets/admin/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="/assets/admin/plugins/chartist/js/chartist.min.js"></script>
    <script src="/assets/admin/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="/assets/admin/js/dashboard/dashboard-1.js"></script>
</body>
</html>