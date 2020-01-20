@extends ('frontend.layouts.app')

@section('title')
    {{ trans('general.url.agent_create') }}
@endsection

@section('content')
    {{ Form::open(['route' => ['frontend.agents.update',1], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST', 'id' => 'create-permission', 'files' => true]) }}

        <div class="modal-header">
            <h5 class="modal-title">{{ trans('labels.agents.edit_headline') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            {{-- Including Form blade file --}}
            @include("frontend.agents.form")
        </div>
        <div class="modal-footer">
            <div class="col-lg-12">
                {{ link_to_route('frontend.agents.index', trans('labels.agents.cancel'), [], ['class' => 'btn btn-secondary btn-md']) }}
                {{ Form::submit(trans('labels.agents.save'), ['class' => 'btn btn-primary btn-md']) }}
            </div>
        </div>
    {{ Form::close() }}
@endsection
