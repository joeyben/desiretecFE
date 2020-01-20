@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.login') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = "#092a5e";
    </script>
@endsection

@section('after-scripts')
    <script type="application/javascript">
        $(document).ready(function(){
            $('.primary-btn').css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            $('.secondary-btn').css({
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            });
            $("input").focus(function(){
                $(this).css({'border-color': brandColor});
            });
            $("input").blur(function(){
                $(this).css({'border-color': 'inherit'});
            });
        });
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('frontend.auth.api.link') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} mb-0">
                            <div class="row p-4 pb-0">
                                <div class="col-md-4">
                                    <label for="email" class="control-label">{{ trans('labels.frontend.tokenlogin.email') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row p-4">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>

                                <div class="col-md-8">
                                    <button type="submit" class="btn primary-btn mb-0">
                                        {{ trans('button.tokenlogin.send') }}
                                    </button>
                                    <a href="{{route('frontend.auth.login')}}" class="btn secondary-btn">
                                        {{ trans('account.login.seller') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
