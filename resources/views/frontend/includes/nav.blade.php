<nav class="header navbar navbar-expand-lg navbar-light info-color fixed-top">
    <a class="navbar-brand logo" href="{{ route('frontend.index', [$subdomain]) }}">
        <img class="" src="{{ getWhitelabelInfo()['attachments']['logo'] }}">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse navbar-right" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto float-right">
            @if ($logged_in_user && $logged_in_user['isSeller'])
                <li class="nav-item"><a href="{{ route('frontend.wishes.list', [$subdomain]) }}" class="link-btn-secondary">{{ trans('navs.frontend.wisheslist') }}</a></li>
                @if($currentAgent)
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle link-btn-secondary" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img class="agent-menu-img avatar-size-3 avatar-circle" src="{{ Storage::disk('s3')->url('img/agent/' . $currentAgent['avatar']) }}">
                            <span>{{ $currentAgent['name'] }}</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right dropdown-menu-agent" role="menu">
                            @foreach($agentsForSeller as $agent)
                                <li class="nav-item">
                                    <a href="{{ route('frontend.agents.switch', ['id' => $agent['id'], 'subdomain' => $subdomain]) }}" class="link-btn-secondary">
                                        <img class="agent-dropdown-img avatar-size-2 avatar-circle" src="{{ Storage::disk('s3')->url('img/agent/' . $agent['avatar']) }}">
                                        <span>{{ $agent['name'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endif

            @if (! $logged_in_user)
                <li class="nav-item"><a href="{{ route('frontend.auth.sendtoken', [$subdomain]) }}" class="link-btn-secondary">{{ trans('navs.frontend.login') }}</a></li>

                @if (config('access.users.registration') && false)
                    <li class="nav-item">{{ link_to_route('frontend.auth.register', trans('navs.frontend.register')) }}</li>
                @endif

            @else
                <li class="dropdown nav-item dropdown-user">
                    <a class="dropdown-toggle link-btn-secondary" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="">
                        @if ($logged_in_user['name'] == "Muster Name")
                            {{ trans('navs.frontend.user.name') }}
                        @else
                            {{ $logged_in_user['name'] }}
                        @endif
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink-4">
                        @if ($logged_in_user && ($logged_in_user['role'] === "Executive"))
                            <a class="dropdown-item link-btn-secondary" href="{{ env('ADMIN_URL', 'https://admin.desiretec.com') . '/admin/dashboard#/' }}" target="_blank" >Administration</a>
                        @endif

                        @if ($logged_in_user && $logged_in_user['role'] === "Seller")
                            <a class="dropdown-item link-btn-secondary" href="{{ route('frontend.agents.index', [$subdomain]) }}">{{ trans('navs.frontend.agents') }}</a>
                            <a class="dropdown-item link-btn-secondary" href="{{ route('frontend.offers.index', [$subdomain]) }}">{{ trans('navs.frontend.offers') }}</a>
                        @endif

                        @if ($logged_in_user && ($logged_in_user['role'] === "Seller" || $logged_in_user['role'] === "Executive"))
                            <a class="dropdown-item link-btn-secondary" href="{{ route('frontend.wishes.list', [$subdomain]) }}">{{ trans('navs.frontend.wisheslist') }}</a>
                        @endif

                        @if ($logged_in_user && $logged_in_user['role'] === "User")
                            <a class="dropdown-item link-btn-secondary" href="{{ route('frontend.wishes.list', [$subdomain]) }}">{{ trans('navs.frontend.wishes') }}</a>
                        @endif

                        <a class="dropdown-item link-btn-secondary" href="{{ route('frontend.user.account', [$subdomain]) }}">{{ trans('navs.frontend.user.account') }}</a>
                    </div>
                </li>
            @endif

            @if ($logged_in_user)
                <li class='nav-item logout'><a href="{{ route('frontend.auth.api.logout', [$subdomain]) }}" class="link-btn-secondary"><i class="fal fa-sign-out"></i></a></li>
            @endif

        </ul>
    </div>
</nav>
