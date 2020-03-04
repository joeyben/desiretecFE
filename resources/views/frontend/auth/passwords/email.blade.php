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
                    {{ Form::open(['route' => ['frontend.auth.api.password', $subdomain], 'class' => 'form-horizontal']) }}

                    <div class="form-group float-label">
                        {{ Form::input('email', 'email', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
                        {{ Form::label('email', trans('validation.attributes.frontend.register-user.email')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit(trans('labels.frontend.passwords.send_password_reset_link_button'), ['class' => 'btn btn-primary']) }}
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
