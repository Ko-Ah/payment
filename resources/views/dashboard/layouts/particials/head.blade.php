<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}">
    <!-- Fonts -->

    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
   {{-- @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/nucleo-icons.css')}}">
    <link rel="stylesheet" href="{{asset('css/nucleo-svg.css')}}">
     <link id="pagestyle" rel="stylesheet" href="{{asset('css/material-dashboard.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/all.css')}}" />
    <style>
        #modal_adduser .form-group {
            position: relative;
        }
        #modal_update_adduser .form-group {
            position: relative;
        }

        #modal_adduser .form-group .post_tag_icon {
            position: absolute;
            top: 60px;
            right:440px;
        }
        #modal_update_adduser .form-group .update {
            position: absolute;
            top: 60px;
            right:440px;
        }
    </style>
</head>
