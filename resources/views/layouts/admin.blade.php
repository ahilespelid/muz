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
    <link href="/assets/plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="/assets/plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="/assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">

</head>

<body>
    @yield('body')

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="/assets/plugins/common/common.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/gleek.js"></script>
    <script src="/assets/js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="/assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="/assets/plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="/assets/plugins/d3v3/index.js"></script>
    <script src="/assets/plugins/topojson/topojson.min.js"></script>
    <script src="/assets/plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="/assets/plugins/raphael/raphael.min.js"></script>
    <script src="/assets/plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="/assets/plugins/moment/moment.min.js"></script>
    <script src="/assets/plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="/assets/plugins/chartist/js/chartist.min.js"></script>
    <script src="/assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="/assets/js/dashboard/dashboard-1.js"></script>
</body>
</html>