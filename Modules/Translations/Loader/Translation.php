<?php


namespace Modules\Translations\Loader;

use App\Services\Api\ApiService;
use Illuminate\Support\Facades\Cache;
use Spatie\TranslationLoader\TranslationLoaders\TranslationLoader;


class Translation implements TranslationLoader
{
    public function loadTranslations(string $locale, string $group): array
    {

        return Cache::rememberForever(static::getCacheKey($group, $locale), function () use ($group, $locale) {
            $api = resolve(ApiService::class);
            $response = $api->post('/translations', ['group' => $group, 'locale' => $locale]);

            return $response->formatResponse('array');
        });
    }

    public static function getCacheKey(string $group, string $locale): string
    {
        return "spatie.translation-loader.{$group}.{$locale}";
    }
}
