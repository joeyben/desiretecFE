@extends('frontend.whitelabel.master')

@section('content')
    <div class="slider" style="background-image: url({{ getWhitelabelInfo()->background  }})">
        <div class="welcome">
        {{ trans('whitelabel.frontend.welcome') }}
        <strong>{{ trans('whitelabel.frontend.name', ['whitelabel' => getWhitelabelInfo()->display_name]) }} {{ trans('whitelabel.frontend.wish_portal') }}</strong>
        </div>

        <div class="layer-action">
            <a href="javascript:showLayer();" class="btn btn-primary btn-md">{{ trans('navs.frontend.create_wish') }}</a>
        </div>
    </div>
@endsection

@section('footer')
    @include('frontend.whitelabel.footer')
@endsection
