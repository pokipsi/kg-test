<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>KG Test</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
    </head>
    <body>
        <div class="alert alert-primary" role="alert">
            Reactivated succesfully! <a href="/">Home</a>
        </div>
    </body>
</html>
