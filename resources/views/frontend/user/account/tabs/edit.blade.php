
{{ Form::model($user, ['route' => [ 'frontend.user.update', $subdomain, $logged_in_user['id']], 'class' => 'form-horizontal', 'method' => 'PUT']) }}
    <div class="form-group float-label">
        {{ Form::input('text', 'first_name', null, ['id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('first_name', trans('validation.attributes.frontend.register-user.firstName')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('text', 'last_name', null, ['id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('last_name', trans('validation.attributes.frontend.register-user.lastName')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('email', 'email', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('email', trans('validation.attributes.frontend.register-user.email')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('textarea', 'address', null, ['id' => 'address', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('address', trans('validation.attributes.frontend.register-user.address')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('text', 'zip_code', null, ['id' => 'zip_code', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('zip_code', trans('validation.attributes.frontend.register-user.zipcode')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('text', 'city', null, ['id' => 'city', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('city', trans('validation.attributes.frontend.register-user.city')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::input('text', 'country' , null, ['id' => 'country', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
        {{ Form::label('country', trans('validation.attributes.frontend.register-user.country')) }}
    </div>

    <div class="form-group">
        {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn primary-btn', 'id' => 'update-profile']) }}
    </div>

{{ Form::close() }}
