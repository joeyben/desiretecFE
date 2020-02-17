{{ Form::open(['route' => ['frontend.auth.password.change', $subdomain], 'class' => 'form-horizontal', 'method' => 'patch']) }}

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('password', 'old_password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.old_password')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.new_password')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.new_password_confirmation')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn primary-btn', 'id' => 'change-password']) }}
        </div>
    </div>

{{ Form::close() }}
