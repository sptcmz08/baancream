<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public static function getValue(string $key, mixed $default = null): mixed
    {
        $value = Cache::rememberForever("site_setting:{$key}", function () use ($key) {
            return static::query()->where('key', $key)->value('value');
        });

        return $value ?? $default;
    }

    public static function setValue(string $key, mixed $value): void
    {
        static::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );

        Cache::forget("site_setting:{$key}");
    }

    public static function forgetValue(string $key): void
    {
        static::query()->where('key', $key)->delete();

        Cache::forget("site_setting:{$key}");
    }

    public static function publicUrl(string $key): ?string
    {
        $path = static::getValue($key);

        if (! $path || ! Storage::disk('public')->exists($path)) {
            return null;
        }

        try {
            return route('branding.logo');
        } catch (\Exception $e) {
            // Fallback: serve directly via storage URL if route cache is stale
            return Storage::disk('public')->url($path);
        }
    }
}
