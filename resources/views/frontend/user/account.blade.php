@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.account') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getWhitelabelInfo()['color']) !!};
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center">

            <div class="card col-md-6 p-3">

                <div class="card-header">
                    <h4>{{ trans('navs.frontend.user.account') }}</h4>
                </div>

                <div class="card-body">

                    <div role="tabpanel">

                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="nav-item" id="li-profile">
                                <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab" class="nav-link active">{{ trans('navs.frontend.user.profile') }}</a>
                            </li>

                            <li role="presentation" class="nav-item" id="li-edit">
                                <a href="#edit" aria-controls="edit" role="tab" data-toggle="tab" class="nav-link">{{ trans('navs.frontend.user.update_profile') }}</a>
                            </li>

                            {{-- @if ($logged_in_user->canChangePassword() && !$logged_in_user->hasRole('User')) --}}
                                <li role="presentation" class="nav-item" id="li-password">
                                    <a href="#password" aria-controls="password" role="tab" data-toggle="tab" class="nav-link">{{ trans('navs.frontend.user.change_password') }}</a>
                                </li>
                            {{-- @endif --}}
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane mt-30 active" id="profile">
                                @include('frontend.user.account.tabs.profile')
                            </div>

                            <div role="tabpanel" class="tab-pane mt-45" id="edit">
                                @include('frontend.user.account.tabs.edit')
                            </div>

                            {{-- @if ($logged_in_user->canChangePassword() && !$logged_in_user->hasRole('User')) --}}
                                <div role="tabpanel" class="tab-pane mt-45" id="password">
                                    @include('frontend.user.account.tabs.change-password')
                                </div>
                            {{-- @endif --}}

                            @include('frontend.user.account.upload-photo-modal')

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection

@section('after-scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('.primary-btn').css({
            'background': brandColor,
            'border': '1px solid ' + brandColor,
            'color': '#fff',
        });

        // To Use Select2
        // Backend.Select2.init();

        if($.session.get("tab") == "edit")
        {
            $("#li-password").removeClass("active");
            $("#li-profile").removeClass("active");
            $("#li-edit").addClass("active");

            $("#profile").removeClass("active");
            $("#password").removeClass("active");
            $("#edit").addClass("active");
        }
        else if($.session.get("tab") == "password")
        {
            $("#li-password").addClass("active");
            $("#li-profile").removeClass("active");
            $("#li-edit").removeClass("active");

            $("#profile").removeClass("active");
            $("#password").addClass("active");
            $("#edit").removeClass("active");
        }

        $(".tabs").click(function() {
            var tab = $(this).attr("aria-controls");
            $.session.set("tab", tab);
        });
    });
</script>
@endsection
