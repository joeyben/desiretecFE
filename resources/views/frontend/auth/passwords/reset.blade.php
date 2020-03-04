@extends('frontend.layouts.app')

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('content')
    <div class="form-group row justify-content-md-center">
        <div class="col-md-6 col-md-offset-2">
            <div class="card card-login">

                <div class="card-header">
                    <h4>{{ trans('labels.frontend.passwords.reset_password_box_title') }}</h4>
                </div>

                <div class="card-body">
                    {{ Form::open(['route' => ['frontend.auth.api.changePassword', $subdomain], 'class' => 'form-horizontal', 'method' => 'put']) }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            {{ Form::label('email', trans('validation.attributes.frontend.register-user.email')) }}
                            {{ Form::input('hidden', 'email', $email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                            <p>{{ $email }}</p>
                        </div>

                        <div class="form-group float-label">
                            {{ Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
                            {{ Form::label('password', trans('validation.attributes.frontend.register-user.password')) }}
                        </div>

                        <div class="form-group float-label">
                            {{ Form::input('password', 'password_confirmation', null, ['id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
                            {{ Form::label('password_confirmation', trans('validation.attributes.frontend.register-user.password_confirmation')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::submit(trans('labels.frontend.passwords.reset_password_button'), ['class' => 'btn btn-primary']) }}
                        </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
