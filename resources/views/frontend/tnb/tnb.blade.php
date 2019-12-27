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
        @if(isWhiteLabel())
            <link rel="icon" type="image/png" href="{{ getWhiteLabelLogoUrl('favicon') }}">
        @else
            <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}">
        @endif
        <!-- Meta -->
        <meta name="description" content="@yield('meta_description', 'desiretec')">
        <meta name="author" content="@yield('meta_author', 'Joe Ben Slimane')">
    </head>
    <body id="app-layout" class="{{ ( ! empty($body_class) ? $body_class : '' )}}" style="margin-bottom:30px; margin-top:30px;margin-right:20px;margin-left:20px;text-align: justify;text-justify:inter-word;">
        {!! Lang::get('layer.footer.tnb') !!}
    </body>
</html>