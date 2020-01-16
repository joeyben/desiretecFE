@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.offer_create') }}
@endsection

@section('content')
    {{ Form::open(['route' => 'frontend.offers.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-offer', 'files' => true]) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.frontend.offers.create') }}</h3>

            </div><!-- /.box-header -->

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("frontend.offers.form")
                    <div class="edit-form-btn">
                    {{ link_to_route('frontend.offers.index', trans('buttons.general.cancel'), [], ['class' => 'secondary-btn small-btn']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'primary-btn']) }}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
@endsection
