@extends ('frontend.layouts.app')

@section ('title', trans('labels.backend.wishes.management') . ' | ' . trans('labels.backend.wishes.edit'))

@section('before-scripts')
    <script type="text/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('after-scripts')
    <script type="text/javascript">
        var cssPrimaryBtn = '.primary-btn { background: ' + brandColor + ' !important; border: 1px solid ' + brandColor + ' !important; } ';
        $('head').append('<style>' + cssPrimaryBtn + '</style>');
    </script>
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.wishes.management') }}
        <small>{{ trans('labels.backend.wishes.edit') }}</small>
    </h1>
@endsection

@section('content')

    {{ Form::model($wish, ['route' => ['frontend.wishes.update', $wish], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role', 'files' => true]) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.wishes.edit') }}</h3>
            </div><!-- /.box-header -->

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("frontend.wishes.form")
                    <div class="edit-form-btn">
                    {{ link_to_route('frontend.wishes.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
@endsection