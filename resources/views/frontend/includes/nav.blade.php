<!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-light info-color fixed-top">
    <a class="navbar-brand logo" href="{{ route('frontend.index', ['subdomain']) }}">
        <img class="" src="{{ $logo }}">
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            @if ($logged_in_user && $logged_in_user->hasRole('Seller'))
                <li class="nav-item">{{ link_to_route('frontend.wishes.list', trans('navs.frontend.wisheslist')) }}</li>
                @if(false)
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ $logged_agent}}
                            <img class="agent-menu-img" src="{{ Storage::disk('s3')->url('img/agent/' . $logged_avatar) }}">
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($agents as $agent)
                                <li class="nav-item">
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
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        @if ($logged_in_user->name == "Muster Name")
                            {{ trans('navs.frontend.user.name') }}
                        @else
                            {{ $logged_in_user->name }}
                        @endif
                            <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                        @if ($logged_in_user && $logged_in_user->hasRole('Seller'))
                            {{ link_to_route('frontend.agents.index', trans('navs.frontend.agents'),'',['class'=>'dropdown-item']) }}
                            {{ link_to_route('frontend.offers.index', trans('navs.frontend.offers'),'',['class'=>'dropdown-item']) }}
                        @endif

                        @if ($logged_in_user && ($logged_in_user->hasRole('User') || $logged_in_user->hasRole('Executive')))
                            {{ link_to_route('frontend.wishes.list', trans('navs.frontend.wishes'),'',['class'=>'dropdown-item']) }}
                        @endif

                        {{ link_to_route('frontend.user.account', trans('navs.frontend.user.account'),'',['class'=>'dropdown-item']) }}

                    </div>
                </li>
            @endif
            @if ($logged_in_user)
                <li class='logout'><a href="{{route('frontend.auth.api.logout')}}"><i class="fal fa-sign-out"></i></a></li>
            @endif



        </ul>
    </div>
</nav>
<!--/.Navbar -->
