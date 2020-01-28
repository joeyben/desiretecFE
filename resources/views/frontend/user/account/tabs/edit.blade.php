{{ Form::model($logged_in_user, ['route' => ['frontend.user.update',$logged_in_user->id], 'class' => 'form-horizontal', 'method' => 'PUT']) }}

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('text', 'first_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.firstName')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('text', 'last_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.firstName')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('textarea', 'address', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.address')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('text', 'zip_code', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.zipcode')]) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('text', 'city', null, ['class' => 'form-control select2', 'placeholder' => trans('validation.attributes.frontend.register-user.city'), 'id' => 'city']) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('text', 'country' , null, ['class' => 'form-control select2', 'placeholder' => trans('validation.attributes.frontend.register-user.country'), 'id' => 'country']) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn primary-btn', 'id' => 'update-profile']) }}
        </div>
    </div>

{{ Form::close() }}
