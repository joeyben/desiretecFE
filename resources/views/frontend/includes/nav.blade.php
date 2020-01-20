<nav class="navbar navbar-default navbar-fixed-top main-nav">
    <div class="container-fluid">
        <div class="navbar-header">

           {{--   @if(settings()->logo)
            <a href="{{ route('frontend.index') }}" class="logo"><img height="48" width="226" class="navbar-brand" src="{{route('frontend.index')}}/img/site_logo/{{settings()->logo}}"></a>
            @else
             {{ link_to_route('frontend.index',app_name(), [], ['class' => 'navbar-brand']) }}
           {{--  @endif --}}
            <a href="{{ route('frontend.index') }}" class="logo">
                <img class="navbar-brand" src="{{route('frontend.index')}}/img/logo.png">
            </a>


        </div><!--navbar-header-->

        <div class="collapse navbar-collapse show" id="frontend-navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                @yield('demo')
                @if (config('locale.status') && count(config('locale.languages')) > 1 && false)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('menus.language-picker.language') }}
                            <span class="caret"></span>
                        </a>

                        @include('includes.partials.lang')
                    </li>
                @endif

                @if ($logged_in_user && $logged_in_user->hasRole('Seller'))
                    <li>{{ link_to_route('frontend.wishes.list', trans('navs.frontend.wisheslist')) }}</li>
                    @if(false)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ $logged_agent}}
                            <img class="agent-menu-img" src="{{ Storage::disk('s3')->url('img/agent/' . $logged_avatar) }}">
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($agents as $agent)
                            <li>
                                <a href="{{route('frontend.agents.status', $agent->id)}}" >
                                    <img class="agent-dropdown-img" src="{{ Storage::disk('s3')->url('img/agent/' . $agent->avatar) }}">
                                    <span>{{ $agent->name }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                @endif

                @if ($logged_in_user && $logged_in_user->hasRole('User'))
                   <!-- <li>{{ link_to_route('frontend.wishes.create', trans('navs.frontend.create_wish')) }}</li> -->
                @endif

                @if (! $logged_in_user)
                    <li>{{ link_to_route('frontend.auth.sendtoken', trans('navs.frontend.login')) }}</li>

                    @if (config('access.users.registration') && false)
                        <li>{{ link_to_route('frontend.auth.register', trans('navs.frontend.register')) }}</li>
                    @endif
                @else
                    <li class="dropdown nav-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            @if ($logged_in_user->name == "Muster Name")
                                {{ trans('navs.frontend.user.name') }}
                            @else
                                {{ $logged_in_user->name }}
                            @endif
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if ($logged_in_user && $logged_in_user->hasRole('Seller'))
                                <li>{{ link_to_route('frontend.agents.index', trans('navs.frontend.agents')) }}</li>
                                <li>{{ link_to_route('frontend.offers.index', trans('navs.frontend.offers')) }}</li>
                            @endif

                            @if ($logged_in_user && ($logged_in_user->hasRole('User') || $logged_in_user->hasRole('Executive')))
                                <li>{{ link_to_route('frontend.wishes.list', trans('navs.frontend.wishes')) }}</li>
                            @endif

                            <li>{{ link_to_route('frontend.user.account', trans('navs.frontend.user.account')) }}</li>

                        </ul>
                    </li>
                @endif
                    @if ($logged_in_user)
                    <li class='logout'><a href="{{route('frontend.auth.api.logout')}}"><i class="fal fa-sign-out"></i></a></li>
                    @endif

            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>
