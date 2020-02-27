{{ Form::open(['route' => ['frontend.user.changePassword', $subdomain], 'class' => 'form-horizontal', 'method' => 'put']) }}

    <div class="form-group float-label">
        {{ Form::input('password', 'old_password', null, ['id' => 'old_password', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('old_password', trans('validation.attributes.frontend.register-user.old_password')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('password', trans('validation.attributes.frontend.register-user.new_password')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('password', 'password_confirmation', null, ['id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('password_confirmation', trans('validation.attributes.frontend.register-user.new_password_confirmation')) }}
    </div>

    <div class="form-group">
        {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn primary-btn', 'id' => 'change-password']) }}
    </div>

{{ Form::close() }}
