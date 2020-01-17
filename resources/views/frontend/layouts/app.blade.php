@php
    use Illuminate\Support\Facades\Route;
@endphp
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', app_name())</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}">
        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'desiretec')">
        <meta name="author" content="@yield('meta_author', 'Joe Ben Slimane')">
        @yield('meta')

        <!-- Styles -->
        @yield('before-styles')

        <!-- Check if the language is set to RTL, so apply the RTL layouts -->
        <!-- Otherwise apply the normal LTR layouts -->

        {{ Html::style(mix('css/frontend.css')) }}

        {{-- {!! Html::style('js/select2/select2.min.css') !!} --}}

    @yield('after-styles')
        <style type="text/css">

        </style>
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
        {!! Html::script(mix('js/frontend.js')) !!}
        @yield('after-scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.js"></script>

        <script type="text/javascript">
            if("{{Route::currentRouteName()}}" !== "frontend.user.account")
            {
                // $.session.clear();
            }
        </script>
    </body>
</html>
