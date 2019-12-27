@extends ('frontend.layouts.app')

@section('title')
    {{ trans('general.url.agent_create') }}
@endsection

@section('content')
    {{ Form::open(['route' => ['frontend.agents.update',$agent->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST', 'id' => 'create-permission', 'files' => true]) }}

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

@section("after-scripts")
    <script type="text/javascript">
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

        $(document).ready(function(){
            var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};

            $('.primary-btn, .btn-primary').css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            $('.secondary-btn, .btn-secondary').css({
                'background': '#fff',
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            });
            $("input").focus(function(){
                $(this).css({'border-color': brandColor});
            });
            $("input").blur(function(){
                $(this).css({'border-color': 'inherit'});
            });
        });

    </script>
@endsection