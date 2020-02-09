@extends ('frontend.layouts.app')

@section('title')
    {{ trans('general.url.agent_create') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var
         = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('content')
    {{ Form::open(['route' => ['frontend.agents.store', $subdomain], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}

        <div class="modal-header">
            <h5 class="modal-title">{{isset($customer)?'Edit':'New'}} Customer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            {{-- Including Form blade file --}}
            @include("frontend.agents.form")
        </div>
        <div class="modal-footer">
            {{ link_to_route('frontend.agents.index', 'Cancel', [], ['class' => 'btn btn-danger btn-md']) }}
            {{ Form::submit('Create', ['class' => 'btn btn-primary btn-md']) }}
        </div>
    {{ Form::close() }}
@endsection

@section("after-scripts")
<script>
            console.log('inside');

</script>
<script type="text/javascript">
        $(document).on('change','.up', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
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
