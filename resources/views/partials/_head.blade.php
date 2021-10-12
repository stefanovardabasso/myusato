<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title') - {{ config('app.name') }}</title>

<link rel="shortcut icon" href="{{ asset('images/admin-panel/favicon.png') }}"/>
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/admin-panel/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/admin-panel/favicon.ico') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/admin-panel/favicon.ico') }}">

<link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}" />
<script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@if(Route::currentRouteName() == "admin.statistics")
    {{-- Chart.js CDN used only in admin.statistics page --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
@endif