<?php

namespace Modules\Translations\Entities;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Spatie\TranslationLoader\LanguageLine;

class Translation extends LanguageLine
{

    public static function getTranslationsForGroup(string $locale, string $group): array
    {
        return Cache::rememberForever(static::getCacheKey($group, $locale), function () use ($group, $locale) {
            return static::query()
                    ->where('group', $group)
                    ->get()
                    ->reduce(function ($lines, self $languageLine) use ($locale) {
                        $translation = $languageLine->getTranslation(session()->get('wl-locale', $locale));
                        if ($translation !== null) {
                            Arr::set($lines, $languageLine->key, $translation);
                        }

                        return $lines;
                    }) ?? [];
        });
    }
}
