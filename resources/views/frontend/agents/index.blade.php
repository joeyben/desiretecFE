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
        {{ Form::open(['route' => ['frontend.agents.store', $subdomain], 'class' => 'form-horizontal', 'method' => 'post', 'files' => true]) }}
            <div class="modal-header">
                <h5 class="modal-title">{{isset($customer) ? trans('agent.modal.title.edit') : trans('agent.modal.title.new') }}</h5>
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
                    <a class="btn secondary-btn" href="{{ route('frontend.agents.index', [$subdomain]) }}">{{ trans('seller.agent.create.cancel') }}</a>
                    {{ Form::button(trans('seller.agent.create.submit'), ['type' => 'submit','class' => 'btn primary-btn']) }}
                </div>
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.frontend.agents.management') }}</h3>
        @include('frontend.agents.partials.agents-header-buttons')
    </div>

    <div class="box-body">
        <div class="table-responsive data-table-wrapper">
            <table id="agents-table" class="table table-condensed table-hover table-bordered">
                <thead class="transparent-bg">
                    <tr>
                        <th>{{ trans('labels.frontend.agents.table.avatar') }}</th>
                        <th>{{ trans('labels.frontend.agents.table.id') }}</th>
                        <th>{{ trans('labels.frontend.agents.table.name') }}</th>
                        <th>{{ trans('labels.frontend.agents.table.created_at') }}</th>
                        <th>{{ trans('labels.frontend.agents.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agents as $agent)
                        <tr>
                            <td>
                                <img src="{{ $avatar_path . $agent->avatar }}"/>
                            </td>
                            <td>{{ $agent->id }}</td>
                            <td>{{ $agent->name }}</td>
                            <td>{{ $agent->created_at }}</td>
                            <td>

                                <a class="" href="{{ route('frontend.agents.edit', [$subdomain, $agent->id]) }}">{{ trans('labels.agents.edit') }}</a>
                                <span> / </span>
                                <a class="" href="{{ route('frontend.agents.delete', [$subdomain, $agent->id]) }}">{{ trans('labels.agents.delete') }}</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
