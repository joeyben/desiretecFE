@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.login') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('content')
<div class="container">
    <div class="form-group row justify-content-md-center">
        <div class="col-md-6 col-md-offset-2">
            <div class="card card-login">
                <div class="card-header">
                    <h4>{{ trans('labels.frontend.auth.login_box_title') }}</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('frontend.auth.api.link', [$subdomain]) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} float-label">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="invisible" required>
                            <label for="email" class="control-label">{{ trans('labels.frontend.tokenlogin.email') }}</label>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn primary-btn mb-3">
                                {{ trans('button.tokenlogin.send') }}
                            </button>
                            <a href="{{route('frontend.auth.login', [$subdomain])}}" class="btn secondary-btn mb-3">
                                {{ trans('account.login.seller') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
