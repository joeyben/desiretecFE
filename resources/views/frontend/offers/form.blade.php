<div class="box-body">
    <div class="form-group float-label">
        {{ Form::text('title', null, ['id' => 'title', 'class' => 'form-control box-size', 'placeholder' => 'transparent', 'required' => 'required']) }}
        {{ Form::label('title', trans('validation.attributes.frontend.offers.title_placeholder')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::textarea('description', null, ['id' => 'description', 'class' => 'form-control', 'placeholder' => 'transparent', 'required' => 'required']) }}
        {{ Form::label('description', trans('validation.attributes.frontend.offers.text_placeholder')) }}
    </div>

    <div class="form-group float-label">
        {{ Form::text('link', null, ['id' => 'link', 'class' => 'form-control box-size', 'placeholder' => 'transparent']) }}
        {{ Form::label('link', trans('validation.attributes.frontend.offers.link_placeholder')) }}
    </div>

    <div class="form-group">
        {{ Form::label('file', trans('validation.attributes.frontend.offers.file'), ['class' => 'col-lg-2 control-label required']) }}
        @if(!empty($offer->featured_image))
            <div class="col-lg-1">
                <img src="{{ Storage::disk('s3')->url('img/offer/' . $offer->featured_image) }}" height="80" width="80">
            </div>
            <div class="custom-file-input">
                <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
            </div>
        @else
            <div class="input-group">
                <input type="text" class="form-control readonly" readonly>
                <div class="input-group-btn">
                    <span class="fileUpload btn primary-btn">
                        <span class="upl" id="upload">{{ trans('offer.file.upload') }}</span>
                        <input type="file" name="file[]" class="upload up" id="up" onchange="" multiple/>
                    </span><!-- btn-orange -->
                </div><!-- btn -->
            </div><!-- group -->
            <p class="info_upload">{{ trans('offers.upload.image_types') }}</p>
        @endif
    </div><!--form control-->

    <div class="form-group">
        {{ Form::hidden('status', $status['Active']) }}
        {{ Form::hidden('wish_id', $wish_id) }}
    </div><!--form control-->
</div>

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section("after-scripts")
    <script type="text/javascript">
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
