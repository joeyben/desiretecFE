<div class="form-group float-label">
    @if(!empty($agent->name))
        {{ Form::text('name', $agent->name, ['id' => 'firstName', 'class' => 'form-control box-size', 'placeholder' => 'transparent', 'required' => 'required']) }}
    @else
        {{ Form::text('name', null, ['id' => 'firstName', 'class' => 'form-control box-size', 'placeholder' => 'transparent', 'required' => 'required']) }}
    @endif
    {{ Form::label('firstName', trans('seller.agent.first_name')) }}
</div>

<div class="form-group float-label">
    @if(!empty($agent->email))
        {{ Form::email('email', $agent->email, ['id' => 'email', 'class' => 'form-control box-size', 'placeholder' => 'transparent', 'required' => 'required']) }}
    @else
        {{ Form::email('email', null, ['id' => 'email', 'class' => 'form-control box-size', 'placeholder' => 'transparent', 'required' => 'required']) }}
    @endif
    {{ Form::label('email', trans('seller.agent.email_placeholder')) }}
</div>

<div class="form-group float-label">
    @if(!empty($agent->telephone))
        {{ Form::text('telephone', $agent->telephone, ['id' => 'telephone', 'class' => 'form-control box-size', 'placeholder' => 'transparent', 'required' => 'required']) }}
    @else
        {{ Form::text('telephone', null, ['id' => 'telephone', 'class' => 'form-control box-size', 'placeholder' => 'transparent', 'required' => 'required']) }}
    @endif
    {{ Form::label('telephone', trans('seller.agent.tel_placeholder')) }}
</div>

<div class="form-group">
    @if(!empty($agent->featured_image))
        <div class="col-lg-1">
            <img src="{{ Storage::disk('s3')->url('img/agent/' . $agent->featured_image) }}" height="80" width="80">
        </div>
        <div class="col-lg-5">
            <div class="custom-file-input">
                <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                <label for="file-1"><i class="fa fa-upload"></i><span>{{ trans('agent.image.choose_file') }}</span></label>
            </div>
        </div>
    @else
        <div class="input-group">
            <input type="text" class="form-control readonly" readonly>
            <div class="input-group-btn">
                <span class="fileUpload btn primary-btn">
                    <span class="upl" id="upload">{{ trans('agent.image.upload') }}</span>
                    <input type="file" name="avatar" class="upload up" id="up" onchange="" />
                </span>
            </div>
        </div>
    @endif
</div>
