<!DOCTYPE html>
<html lang="{{ Auth::user()->locale }}" class="page @php
    $class = "page-";
    foreach($view_path_array as $view_path){
        $class .= "-".$view_path;
        echo $class.(next($view_path_array)?" ":"");
    }
@endphp">

<head>
    @include('partials._head')
</head>

<body class="skin-green-light sidebar-mini fixed">

<div id="preloader"><div id="status"></div></div>        
       
<div class="wrapper" id="app">
    
@include('partials._topbar')
@include('partials._sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    @yield('content')

                </div>
            </div>
        </section>
    </div>
    <footer class="main-footer">
        @include('partials._footer')
    </footer>
</div>

@include('partials._javascripts-lang')

<script src="{{ mix('js/app.js') }}"></script>

@include('partials._javascripts')

</body>
</html>
