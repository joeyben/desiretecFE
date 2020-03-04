@extends ('frontend.layouts.app')

@section('title')
    {{ trans('general.url.agent_create') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('content')
    {{ Form::open(['route' => ['frontend.agents.update',$subdomain, $agent->id], 'class' => 'form-horizontal  col-md-6 mx-auto', 'role' => 'form', 'method' => 'POST', 'id' => 'create-permission', 'files' => true]) }}
        <div class="modal-header pb-20">
            <h4>{{ trans('labels.agents.edit_headline') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            {{-- Including Form blade file --}}
            @include("frontend.agents.form")
        </div>
        <div class="modal-footer">
            <a class="btn btn-secondary btn-md" href="{{ route('frontend.agents.index', [$subdomain]) }}">{{ trans('labels.agents.cancel') }}</a>

            {{ Form::submit(trans('labels.agents.save'), ['class' => 'btn btn-primary btn-md']) }}
        </div>
    {{ Form::close() }}
@endsection

@section('footer')
    @include('frontend.whitelabel.footer')
@endsection

@section("after-scripts")
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
