@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.agent') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('content')
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal_content">
        {{ Form::open(['route' => ['frontend.agents.store', $subdomain], 'class' => 'form-horizontal p-3', 'method' => 'post', 'files' => true]) }}
            <div class="modal-header pb-30">
                <h4>{{isset($customer) ? trans('agent.modal.title.edit') : trans('agent.modal.title.new') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Including Form blade file --}}
                @include("frontend.agents.form")
            </div>
            <div class="modal-footer">
                <a class="btn secondary-btn" href="{{ route('frontend.agents.index', [$subdomain]) }}">{{ trans('seller.agent.create.cancel') }}</a>
                {{ Form::button(trans('seller.agent.create.submit'), ['type' => 'submit','class' => 'btn primary-btn']) }}
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>

<div class="box box-info">
    <div class="box-header">
        <h3 class="mb-30">{{ trans('labels.frontend.agents.management') }}</h3>
        @include('frontend.agents.partials.agents-header-buttons')
    </div>

    <div class="box-body">
        <div class="table-responsive data-table-wrapper">
            <table id="agents-table" class="table table-condensed table-hover">
                <thead class="transparent-bg">
                    <tr>
                        <th>{{ trans('labels.frontend.agents.table.avatar') }}</th>
                        <th>{{ trans('labels.frontend.agents.table.name') }}</th>
                        <th>{{ trans('labels.frontend.agents.table.created_at') }}</th>
                        <th>{{ trans('labels.frontend.agents.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                        <tr>
                            <td>
                                <img src="{{ Storage::disk('s3')->url('img/agent/' . $agent->avatar) }}"/>
                            </td>
                            <td>{{ $agent->name }}</td>
                            <td>{{ $agent->created_at }}</td>
                            <td>
                                <a class="link-btn-primary" href="{{ route('frontend.agents.edit', [$subdomain, $agent->id]) }}">{{ trans('labels.agents.edit') }}</a>
                                <span> / </span>
                                <a class="link-btn-primary" href="{{ route('frontend.agents.delete', [$subdomain, $agent->id]) }}">{{ trans('labels.agents.delete') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('frontend.whitelabel.footer')
@endsection
