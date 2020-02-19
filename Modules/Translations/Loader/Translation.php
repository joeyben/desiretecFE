<?php


namespace Modules\Translations\Loader;

use App\Services\Api\ApiService;
use Illuminate\Support\Facades\Cache;
use Spatie\TranslationLoader\TranslationLoaders\TranslationLoader;


class Translation implements TranslationLoader
{
    public function loadTranslations(string $locale, string $group): array
    {
        $whitelabelId = getWhitelabelInfo()['id'];

        return Cache::rememberForever(static::getCacheKey($group, $locale, $whitelabelId), function () use ($group, $locale, $whitelabelId) {
            $api = resolve(ApiService::class);
            $response = $api->post('/translations', [
                'group' => $group,
                'locale' => $locale,
                'whitelabel_id' => $whitelabelId
            ]);

            return $response->formatResponse('array');
        });
    }

    public static function getCacheKey(string $group, string $locale, int $whitelabelId = null): string
    {
        return "spatie.translation-loader.{$whitelabelId}.{$group}.{$locale}";
    }
}
