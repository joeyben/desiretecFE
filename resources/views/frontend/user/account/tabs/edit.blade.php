{{ Form::model($logged_in_user, ['route' => 'frontend.user.profile.update', 'class' => 'form-horizontal', 'method' => 'POST']) }}

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

    {{-- @if ($logged_in_user->canChangeEmail()) --}}
        <div class="form-group">
            <div class="col-md-12">
                <div class="alert alert-info" role="alert">
                    <i class="fa fa-info-circle"></i> {{  trans('strings.frontend.user.change_email_notice') }}
                </div> 

                {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
            </div>
        </div>
    {{-- @endif --}}

    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('textarea', 'address', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.address')]) }}
        </div>
    </div>

    {{-- zipcode --}}
    <div class="form-group">
        <div class="col-md-12">
            {{ Form::input('text', 'zip_code', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.zipcode')]) }}
        </div>
    </div>

    {{-- city --}}
    <div class="form-group">
        {{ Form::label('city', trans('validation.attributes.frontend.register-user.city'), ['class' => 'col-md-4 control-label']) }}
        <div class="col-md-12">
            {{ Form::input('text', 'city', null, ['class' => 'form-control select2', 'placeholder' => trans('validation.attributes.frontend.register-user.city'), 'id' => 'city', 'style' => 'width : 539px !important;']) }}
        </div>
    </div>

    {{-- state --}}
    <div class="form-group">
        {{ Form::label('country', trans('validation.attributes.frontend.register-user.country'), ['class' => 'col-md-4 control-label']) }}
        <div class="col-md-12">
            {{ Form::input('text', 'country' , null, ['class' => 'form-control select2', 'placeholder' => trans('validation.attributes.frontend.register-user.country'), 'id' => 'country', 'style' => 'width : 539px !important;']) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {{ Form::submit(trans('labels.general.buttons.update'), ['class' => 'btn primary-btn', 'id' => 'update-profile']) }}
        </div>
    </div>

{{ Form::close() }}
