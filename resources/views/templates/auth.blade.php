<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Quản lý Vietname Cozy House">
        <meta name="author" content="Vietsmiler">
        <title>@yield('title')</title>       
        <link rel="shortcut icon" href="{{favicon()}}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
        <link href="{{asset('public/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
        <link href="{{asset('public/style.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('public/css/auth.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('public/css/checkbox_radio.css')}}">
        <link rel="stylesheet" href="{{asset('public/css/pnotify.custom.min.css')}}">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>   
        <script src="{{asset('public/js/pnotify.custom.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('public/js/author.js') }}" type="text/javascript"></script>
    </head>
    <body>
        <div id="wrapper"> @yield('content') </div>
    </body>
    <script src="{{asset('public/js/validator.js')}}" type="text/javascript"></script>
    <script src="{{asset('public/js/validator.min.js')}}" type="text/javascript"></script>
</html>