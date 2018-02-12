<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Hoeveel kost het?!</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>

    <!-- Custom styles for this template -->
    <link href="/css/app.css" rel="stylesheet">
    <script defer src="/js/fontawesome.min.js"></script>
    <script defer src="/js/fa-solid.min.js"></script>
</head>

<body>
<div class="container">

    @auth
        @include('layouts.errors')

        @yield('search')


        <div class="row justify-content-md-center">
            @yield('content')
        </div>
    @else
        <div class="row justify-content-md-center">
            @yield('content')
        </div>
    @endauth
</div>
<!-- /.container -->
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/jquery.cookie.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#productsTable').DataTable({
            "paging": false,
            "info": false,
            "searching": false,
            "order": [[0, 'asc']]
        });
        // If cookie is set, scroll to the position saved in the cookie.
        if ($.cookie("scroll") !== null) {
            $(document).scrollTop($.cookie("scroll"));
            $.removeCookie("scroll");
        }

        // When a link is clicked...
        $('.link-unstyled').on("click", function () {
            // Set a cookie that holds the scroll position.
            $.cookie("scroll", $(document).scrollTop());
        });//end of submit
        $('#search').on("submit", function () {
            // Remove cookie
            $.removeCookie("scroll");
        });//end of submit

    });

</script>
</body>
</html>
