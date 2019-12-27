<ul class="dropdown-menu lang-menu" role="menu">
    @if (!isWhiteLabel())
        @foreach (array_keys(config('locale.languages')) as $lang)
            @if ($lang != App::getLocale())
                <li>{{ link_to('lang/'.$lang, trans('menus.language-picker.langs.'.$lang)) }}</li>
            @endif
        @endforeach
    @endif

    @if (isWhiteLabel())
        @foreach (getWhitelabelLocales() as $lang)
            @if ($lang->locale != App::getLocale())
                <li>{{ link_to('lang/'.$lang->locale, trans('menus.language-picker.langs.'.$lang->locale)) }}</li>
            @endif
        @endforeach
    @endif
</ul>