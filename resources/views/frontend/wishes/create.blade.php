@extends ('frontend.layouts.app')

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        @if(isWhiteLabel())
            <img class="navbar-brand" src="{{ getWhiteLabelLogoUrl() }}">
        @else
            <img class="navbar-brand" src="{{route('frontend.index')}}/img/logo_big.png">
        @endif
    </a>
@endsection

@section ('title', trans('labels.backend.wishes.management') . ' | ' . trans('labels.backend.wishes.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.wishes.management') }}
        <small>{{ trans('labels.backend.wishes.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'frontend.wishes.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.wishes.create') }}</h3>

            </div><!-- /.box-header -->

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("frontend.wishes.form")
                    <div class="edit-form-btn">
                    {{ link_to_route('frontend.wishes.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
@endsection
