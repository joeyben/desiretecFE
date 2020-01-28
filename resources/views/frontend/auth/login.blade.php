@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.login') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('content')

    <div class="row form-group justify-content-md-center">
        @include('includes.alert')
        <div class="col-md-6 col-md-offset-2">

            <div class="card card-login">
                <div class="card-header">
                    <div class="text p-3 pb-0">
                        {{ trans('labels.frontend.auth.login_box_title') }}
                    </div>
                </div>

                <div class="card-body">

                    {{ Form::open(['route' => 'frontend.auth.api.login', 'class' => 'form-horizontal']) }}

                    <div class="form-group p-2 mb-0">
                        {{ Form::label('email', trans('validation.attributes.frontend.register-user.email'), ['class' => 'col-sm-4 col-form-label']) }}
                        <div class="col-sm-12">
                            {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group p-2 mb-0">
                        {{ Form::label('password', trans('validation.attributes.frontend.register-user.password'), ['class' => 'col-sm-4 col-form-label']) }}
                        <div class="col-sm-12">
                            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group p-2">
                        <div class="col-md-12 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    {{ Form::checkbox('remember') }} {{ trans('labels.frontend.auth.remember_me') }}
                                </label>
                            </div>
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group p-2 mb-2">
                        <div class="col-md-12 col-md-offset-4">
                            {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-primary', 'style' => 'margin-right:15px']) }}

                            {{ link_to_route('frontend.auth.password.reset', trans('labels.frontend.passwords.forgot_password')) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    {{ Form::close() }}

                    <div class="row text-center">

                    </div>
                </div><!-- panel body -->

            </div><!-- panel -->

        </div><!-- col-md-8 -->

    </div><!-- row -->

@endsection

@section('after-scripts')
    <script type="application/javascript">
        $(document).ready(function(){
            $('.btn-primary').css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            $("input").focus(function(){
                $(this).css({'border-color': brandColor});
            });
            $("input").blur(function(){
                $(this).css({'border-color': 'inherit'});
            });
            $('.form-group a').css({'color': brandColor});
        });
    </script>
@endsection
