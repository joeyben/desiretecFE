@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.offer_create') }}
@endsection

@section('content')
    {{ Form::open(['route' => ['frontend.offers.store', $subdomain], 'class' => 'form-horizontal col-md-6 mx-auto', 'role' => 'form', 'method' => 'post', 'id' => 'create-offer', 'files' => true]) }}

        <div class="box box-info">
            <div class="box-header mb-30">
                <h4>{{ trans('labels.frontend.offers.create') }}</h4>
            </div>

            <div class="box-body">

                {{-- Including Form blade file --}}
                @include("frontend.offers.form")

                <div class="form-group form-btns">
                    <a class="btn btn-md secondary-btn" href="{{ route('frontend.offers.index', [$subdomain]) }}">{{ trans('buttons.general.cancel') }}</a>
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-md primary-btn']) }}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('footer')
    @include('frontend.whitelabel.footer')
@endsection
