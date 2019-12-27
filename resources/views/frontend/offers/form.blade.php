<div class="box-body">
    <div class="form-group">
        {{ Form::label('title', trans('validation.attributes.frontend.offers.title'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.offers.title_placeholder'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('description', trans('validation.attributes.frontend.offers.text'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.offers.text_placeholder'), 'required' => 'required']) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('link', trans('validation.attributes.frontend.offers.link'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('link', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.offers.link_placeholder')]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('file', trans('validation.attributes.frontend.offers.file'), ['class' => 'col-lg-2 control-label required']) }}
        @if(!empty($offer->featured_image))
            <div class="col-lg-1">
                <img src="{{ Storage::disk('s3')->url('img/offer/' . $offer->featured_image) }}" height="80" width="80">
            </div>
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @else
            <div class="col-lg-5">
                <div class="input-group">
                    <input type="text" class="form-control readonly" readonly>
                    <div class="input-group-btn">
                      <span class="fileUpload btn primary-btn">
                          <span class="upl" id="upload">{{ trans('offer.file.upload') }}</span>
                          <input type="file" name="file[]" class="upload up" id="up" onchange="" multiple/>
                      </span><!-- btn-orange -->
                    </div><!-- btn -->
                </div><!-- group -->
                <p class="info_upload">*Nur PNG und PDF Dateien</p>
            </div>
        @endif
    </div><!--form control-->

    <div class="form-group">
        {{ Form::hidden('status', $status['Active']) }}
        {{ Form::hidden('wish_id', $wish_id) }}
    </div><!--form control-->
</div>

@section("after-scripts")
    <script type="text/javascript">
        $(document).ready(function(){
            console.log('form');
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
            $('.fileUpload').css({
                'padding': '7px 20px',
            });
        });

        $(document).on('change','.up', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            // $("input[name=file]").val(names);
            if(length>2){
                var fileName = names.join(', ');
                $(this).closest('.form-group').find('.form-control').attr("value",length+" files selected");
            }
            else{
                $(this).closest('.form-group').find('.form-control').attr("value",names);
            }
        });
    </script>
@endsection