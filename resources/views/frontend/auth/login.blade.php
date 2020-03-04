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
    <div class="form-group row justify-content-md-center">
        @include('includes.alert')
        <div class="col-md-6 col-md-offset-2">
            <div class="card card-login">
                <div class="card-header mb-10">
                    <h4>{{ trans('labels.frontend.auth.login_box_title') }}</h4>
                </div>
                <div class="card-body">
                    {{ Form::open(['route' => ['frontend.auth.api.login', $subdomain], 'class' => 'form-horizontal']) }}

                        <div class="form-group float-label">
                            {{ Form::input('email', 'email', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'invisible', 'required']) }}
                            {{ Form::label('email', trans('validation.attributes.frontend.register-user.email')) }}
                        </div>

                        <div class="form-group float-label mb-2">
                            {{ Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'invisible', 'required']) }}
                            {{ Form::label('password', trans('validation.attributes.frontend.register-user.password')) }}
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('remember') }} {{ trans('labels.frontend.auth.remember_me') }}
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-primary', 'style' => 'margin-right:15px']) }}
                            <a href="{{ route('frontend.auth.password.reset', [$subdomain]) }}" class="link-btn-primary">{{ trans('labels.frontend.passwords.forgot_password') }}</a>
                        </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
