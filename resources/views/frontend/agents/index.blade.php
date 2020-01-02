@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.agent') }}
@endsection

@section('before-scripts')
    <script type="text/javascript">
        var brandColor = '#000';
    </script>
@endsection

@section('content')
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal_content">
        {{ Form::open(['route' => 'frontend.agents.store', 'class' => 'form-horizontal', 'method' => 'post', 'files' => true]) }}
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
                    {{ link_to_route('frontend.agents.index', trans('seller.agent.create.cancel'), [], ['class' => 'btn secondary-btn']) }}
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
        <div class="box-tools pull-right">

        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="table-responsive data-table-wrapper">
            <table id="agents-table" class="table table-condensed table-hover table-bordered" style="width: 100%;">
                <thead class="transparent-bg">
                <tr>
                    <th>{{ trans('labels.frontend.agents.table.avatar') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.id') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.name') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.created_at') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.status') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.actions') }}</th>
                </tr>
                </thead>
            </table>
        </div><!--table-responsive-->
    </div><!-- /.box-body -->
</div><!--box-->
<!--<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
</div><!-- /.box-header -->
<div class="box-body">
    {{-- {!! history()->renderType('Blog') !!} --}}
</div><!-- /.box-body -->
</div><!--box box-info-->
@endsection
@section('after-scripts')

    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            var dataTable = $('#agents-table').dataTable({
                processing: true,
                serverSide: true,
                bLengthChange:false,
                bInfo:false,
                ajax: {
                    url: '{{ route("frontend.agents.get") }}',
                    type: 'post',
                    dataSrc: ''
                },
                columns: [
                    {data: 'avatar', name: '{{config('module.agents.table')}}.avatar'},
                    {data: 'id', name: '{{config('module.agents.table')}}.name'},
                    {data: 'name', name: '{{config('module.agents.table')}}.display_name'},
                    {data: 'created_at', name: '{{config('module.agents.table')}}.created_at'},
                    {data: 'status', name: '{{config('module.agents.table')}}.status'},
                    {data: 'actions', name: '{{config('module.agents.table')}}.actions'},
                ],

                order: [[4, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [

                    ]
                },
                language: {
                    "search": "Suche",
                    "paginate": {
                        "first":      "Erster",
                        "last":       "Letzter",
                        "next":       "{{ trans('labels.nav.next') }}",
                        "previous":   "{{ trans('labels.nav.prev') }}"
                    },
                }
            });

            //Backend.DataTableSearch.init(dataTable);

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
        });

    </script>

@yield('after-scripts-include')

@endsection
