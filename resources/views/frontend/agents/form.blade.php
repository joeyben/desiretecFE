<div class="form-group">
    <div class="col-lg-12">
        @if(!empty($agent->name))
        {{ Form::text('name', $agent->name, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.first_name'), 'required' => 'required']) }}
        @else
         {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.first_name'), 'required' => 'required']) }}
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-lg-12">
        @if(!empty($agent->email))
        {{ Form::email('email', $agent->email, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.email_placeholder'), 'required' => 'required']) }}
        @else
         {{ Form::email('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.email_placeholder'), 'required' => 'required']) }}
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-lg-12">
        @if(!empty($agent->telephone))
        {{ Form::text('telephone', $agent->telephone, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.tel_placeholder'), 'required' => 'required']) }}
        @else
        {{ Form::text('telephone', null, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.tel_placeholder'), 'required' => 'required']) }}
        @endif
    </div>
</div>

<div class="form-group">
        @if(!empty($agent->featured_image))
            <div class="col-lg-1">
                <img src="{{ Storage::disk('s3')->url('img/agent/' . $agent->featured_image) }}" height="80" width="80">
            </div>
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @else
            <div class="col-lg-12">
                <div class="input-group">
                    <input type="text" class="form-control readonly" readonly>
                    <div class="input-group-btn">
                      <span class="fileUpload btn primary-btn">
                          <span class="upl" id="upload">{{ trans('agent.image.upload') }}</span>
                          <input type="file" name="avatar" class="upload up" id="up" onchange="" />
                      </span><!-- btn-orange -->
                    </div><!-- btn -->
                </div><!-- group -->
            </div>
        @endif
</div>

@section('after-scripts-include')

<script>
    $(document).ready(function(){
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};

        $('.primary-btn').css({
            'background': brandColor,
            'border': '1px solid ' + brandColor,
            'color': '#fff',
        });
        $('.secondary-btn').css({
            'background': '#fff',
            'border': '1px solid ' + brandColor,
            'color': brandColor,
        });
        $("input").focus(function(){
            $(this).css({'border-color': brandColor});
        });
        $("input").blur(function(){
            $(this).css({'border-color': 'inherit'});
        });
    });
</script>

@endsection
