<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SiteSetting extends Model
{
    public const DEFAULT_SHIPPING_RULES = [
        ['min_qty' => 1, 'max_qty' => 5, 'fee' => 30],
        ['min_qty' => 6, 'max_qty' => 10, 'fee' => 50],
        ['min_qty' => 11, 'max_qty' => 20, 'fee' => 70],
        ['min_qty' => 21, 'max_qty' => null, 'fee' => 90],
    ];

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
        try {
            $path = static::getValue($key);

            if (! $path || ! Storage::disk('public')->exists($path)) {
                return null;
            }

            return url('/branding/logo');
        } catch (Throwable) {
            return null;
        }
    }

    public static function shippingBaseFee(): float
    {
        return (float) static::getValue('shipping_base_fee', 30);
    }

    public static function shippingRules(): array
    {
        $storedRules = static::getValue('shipping_rules');
        $rules = is_string($storedRules) ? json_decode($storedRules, true) : null;

        return static::normalizeShippingRules(is_array($rules) ? $rules : static::DEFAULT_SHIPPING_RULES);
    }

    public static function setShippingRules(array $rules): void
    {
        static::setValue('shipping_rules', json_encode(
            static::normalizeShippingRules($rules),
            JSON_UNESCAPED_UNICODE
        ));
    }

    public static function calculateShippingByQuantity(int $totalQty): float
    {
        if ($totalQty <= 0) {
            return 0;
        }

        foreach (static::shippingRules() as $rule) {
            $minQty = (int) $rule['min_qty'];
            $maxQty = $rule['max_qty'] === null ? null : (int) $rule['max_qty'];

            if ($totalQty >= $minQty && ($maxQty === null || $totalQty <= $maxQty)) {
                return (float) $rule['fee'];
            }
        }

        return static::shippingBaseFee();
    }

    public static function normalizeShippingRules(array $rules): array
    {
        $normalized = collect($rules)
            ->filter(fn ($rule) => isset($rule['fee']) && $rule['fee'] !== '')
            ->map(function ($rule) {
                $minQty = max(1, (int) ($rule['min_qty'] ?? 1));
                $maxQty = $rule['max_qty'] ?? null;
                $maxQty = $maxQty === '' || $maxQty === null ? null : max($minQty, (int) $maxQty);
                $fee = max(0, (float) ($rule['fee'] ?? 0));

                return [
                    'min_qty' => $minQty,
                    'max_qty' => $maxQty,
                    'fee' => $fee,
                ];
            })
            ->filter(fn ($rule) => $rule['fee'] >= 0)
            ->sortBy('min_qty')
            ->values()
            ->all();

        return $normalized ?: static::DEFAULT_SHIPPING_RULES;
    }
}
