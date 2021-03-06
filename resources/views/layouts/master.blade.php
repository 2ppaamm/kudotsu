<!doctype html>
<html lang='en'>
<head>
    <meta charset="UTF-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <title>Kudotsu Payment</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body ng-app>
    <div class="container">

        @if (session('flash_message'))
            <div class="alert alert-success">
                {{ session('flash_message') }}
            </div>
        @endif
        <div class="col-md-9">
            @yield('contents')
        </div>
        <div class="col-md-3">
            @section('advertisement')
                <p>The pig is for sale! $29!</p>
            @show
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>