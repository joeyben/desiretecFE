<?php

namespace Modules\Languages\Http\Controllers;

use App\Http\Controllers\Frontend\Admin\CacheController;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class LanguagesController extends Controller
{

    public function switch(string $locale)
    {
        CacheController::empty();

        app()->setLocale($locale);
        session()->put('desiretec.locale', $locale);
        session()->put('wl-locale', $locale);

        return redirect()->back();
    }
}
