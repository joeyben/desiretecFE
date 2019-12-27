<nav class="navbar navbar-default navbar-fixed-top main-nav">
    <div class="container-fluid">
        <div class="navbar-header">
            <!-- <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#frontend-navbar-collapse">
                <span class="sr-only">{{ trans('labels.general.toggle_navigation') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button> -->

           {{--   @if(settings()->logo)
            <a href="{{ route('frontend.index') }}" class="logo"><img height="48" width="226" class="navbar-brand" src="{{route('frontend.index')}}/img/site_logo/{{settings()->logo}}"></a>
            @else
             {{ link_to_route('frontend.index',app_name(), [], ['class' => 'navbar-brand']) }}
           {{--  @endif --}}
            @yield('logo')

            <a href="{{ route('frontend.index') }}" class="logo"><img class="navbar-brand" src="{{'/img/logo_svg.svg'}}"></a>

        </div><!--navbar-header-->

  

            <ul class="nav navbar-nav navbar-right">
                @if (config('locale.status') && count(config('locale.languages')) > 1)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('menus.language-picker.language') }}
                            <span class="caret"></span>
                        </a>

                        @include('includes.partials.lang')
                    </li>
                @endif

                <li class='nav-user'>
                    <img src="/img/frontend/profile-picture/white.jpeg" alt="">
                <span>{{ $logged_in_user->name }}</span></li>
                    @if ($logged_in_user)
                        <li class='logout'><a href="{{route('frontend.auth.logout')}}"><i class='glyphicon glyphicon-log-out'></i></a></li>
                    @endif
            </ul>
     
    </div><!--container-->
</nav>
