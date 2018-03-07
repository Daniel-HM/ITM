<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Daniel Mellema">

    <title>Hoeveel kost het?!</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/datatables-1.10.16.min.css"/>

    <!-- Custom styles for this template -->
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>
<div class="container">

    @auth
        <div class="row justify-content-md-center">
            <div class="col">
                @include('layouts.nav')
                @include('layouts.errors')
                @yield('content')
            </div>
        </div>
    @else
        <div class="row justify-content-md-center">
            <div class="col-lg-4">
                @yield('content')
            </div>
        </div>
    @endauth
</div>
<!-- /.container -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/js/jquery-3.2.1.slim.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
{{--<script src="/js/jquery.cookie.js"></script>--}}
<script type="text/javascript" src="/js/datatables-1.10.16.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#productsTable').DataTable({
            "paging": false,
            "info": false,
            "searching": true,
            "order": [],
            "oLanguage": {
                "sSearch": "Verfijn resultaten"
            }
        });
        // // If cookie is set, scroll to the position saved in the cookie.
        // if ($.cookie("scroll") !== null) {
        //     $(document).scrollTop($.cookie("scroll"));
        //     $.removeCookie("scroll");
        // }
        //
        // // When a link is clicked...
        // $('.link-unstyled').on("click", function () {
        //     // Set a cookie that holds the scroll position.
        //     $.cookie("scroll", $(document).scrollTop());
        // });//end of submit
        // $('#search').on("submit", function () {
        //     // Remove cookie
        //     $.removeCookie("scroll");
        // });//end of submit

    });

</script>
</body>
</html>
