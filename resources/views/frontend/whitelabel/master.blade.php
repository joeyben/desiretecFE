@extends('frontend.layouts.app')

@section('title')
    {!! getWhitelabelInfo()['display_name'] !!}
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}">
@endsection

@section('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script type="application/javascript">
        window.dt = {
            config: { baseUrl: ''  }
        };

        var kwz = document.createElement('script');
        kwz.type = 'application/javascript'; kwz.async = true;
        kwz.src = '/js/layer.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(kwz, s);

        function isMobile() {
            if ($(window).outerWidth() < 769) {
                return true;
            }
            return false;
        }

        function showLayer() {
            if ($(".dt-modal").hasClass("teaser-on")) {
                return false;
            }

            if($(".trigger-modal").length){
                $(".trigger-modal").click();
                return false;
            }

            dt.PopupManager.show();

            if (isMobile()) {
                $("body").addClass('mobile-layer');
                $(".dt-modal").addClass('m-open');

                dt.PopupManager.isMobile = true;
                dt.PopupManager.layerShown = true;
            }
        }
    </script>
@endsection
