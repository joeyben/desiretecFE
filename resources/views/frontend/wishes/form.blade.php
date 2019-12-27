<div class="box-body">
    <div class="form-group">
        {{ Form::label('title', trans('validation.attributes.backend.wishes.title'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.title'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('airport', trans('validation.attributes.backend.wishes.airport'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('airport', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.airport'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('destination', trans('validation.attributes.backend.wishes.destination'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('destination', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.destination'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('earliest_start', trans('validation.attributes.backend.wishes.earliest_start'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('earliest_start', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.earliest_start'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('latest_return', trans('validation.attributes.backend.wishes.latest_return'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('latest_return', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.latest_return'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('adults', trans('validation.attributes.backend.wishes.adults'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::number('adults', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.adults'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('kids', trans('validation.attributes.backend.wishes.kids'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::number('kids', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.kids')]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('budget', trans('validation.attributes.backend.wishes.budget'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::number('budget', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.budget')]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('category', trans('validation.attributes.backend.wishes.category'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::select('category', $category, null, ['class' => 'form-control select2 status box-size', 'placeholder' => trans('validation.attributes.backend.wishes.category')]) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('catering', trans('validation.attributes.backend.wishes.catering'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::select('catering', $catering, null, ['class' => 'form-control select2 status box-size', 'placeholder' => trans('validation.attributes.backend.wishes.catering')]) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('duration', trans('validation.attributes.backend.wishes.duration'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('duration', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.duration')]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('description', trans('validation.attributes.backend.wishes.description'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.wishes.description')]) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('featured_image', trans('validation.attributes.backend.wishes.image'), ['class' => 'col-lg-2 control-label required']) }}
        @if(!empty($wish->featured_image))
            <div class="col-lg-1">
                <img src="{{ Storage::disk('s3')->url('img/wish/' . $wish->featured_image) }}" height="80" width="80">
            </div>
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @else
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @endif
    </div><!--form control-->

</div>

@section("after-scripts")
    <script type="text/javascript">

        
    </script>
@endsection