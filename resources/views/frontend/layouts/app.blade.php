@php
    use Illuminate\Support\Facades\Route;
@endphp
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <link rel="icon" type="image/png" href="{{ getWhitelabelInfo()['attachments']['favicon'] }}">
        <title>@yield('title', app_name())</title>

        @yield('meta')
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta_description', 'desiretec')">
        <meta name="author" content="@yield('meta_author', 'Joe Ben Slimane')">

        @yield('before-styles')
        {{ Html::style(mix('css/frontend.css')) }}
        <link media="all" type="text/css" rel="stylesheet" href="{{ asset('fontawsome/css/all.css') }}">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>
        <?php
            if(!empty($google_analytics)){
                echo $google_analytics;
            }
        ?>
    </head>
    <body id="app-layout" class="{{ ( ! empty($body_class) ? $body_class : '' )}}">
        <div id="app">
            @include('includes.partials.logged-in-as')
            @include('frontend.includes.nav')

            <div class="container main-container">
                @include('includes.alert')
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                        </div>
                    </div>
                </div>
                @yield('content')

            </div><!-- container -->
        </div><!--#app-->
        @yield('footer')

        <!-- Scripts -->
        @yield('before-scripts')
        <script src="{{ mix('js/frontend.js') }}"></script>

        @yield('after-scripts')
        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.js"></script> -->
        <script type="text/javascript">
            if("{{Route::currentRouteName()}}" !== "frontend.user.account")
            {
                // $.session.clear();
            }
        </script>
    </body>
</html>
