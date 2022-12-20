<!DOCTYPE html>
<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"/>
        <link href="/app.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/jquery.js"></script>
        <script>
            // $(document).ready(function () {
            //     $('#itemlist a').on('click', function () {
            //         //var txt = $(this).data("category");
            //         $("#dropdownMenuButton1").text($(this).text());
            //     });
            // });
        </script>
    </head>
    <title>My Blog</title>
    
    <nav class="navbar navbar-expand-md">
            <div class="container-lg">
                <h1><a href="/">My Favourite Books</a></h1>
                <div class="navbar-nav ms-auto"><img src="/book.png" height="300"/></div>
            </div>
    </nav>
    
    <body>
        <div class="d-flex p-4">
        <x-dropdown />
        <x-search />
        </div>
        <div class="container align-items-center">
            {{ $slot }}
        </div>
    </body>
    <footer class="text-white text-center">
        <div class="text-center p-4 copyright">
            Copyright &copy; your website 2022
        </div>
    </footer>
</html>