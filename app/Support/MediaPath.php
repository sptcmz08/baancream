<?php

namespace App\Support;

class MediaPath
{
    public static function normalize(?string $path): ?string
    {
        if (!is_string($path)) {
            return null;
        }

        $normalized = trim($path);

        if ($normalized === '') {
            return null;
        }

        $normalized = str_replace('\\', '/', $normalized);
        $normalized = preg_replace('#^https?://[^/]+/#i', '', $normalized) ?? $normalized;
        $normalized = preg_replace('#^(?:public/|storage/|media/)#i', '', ltrim($normalized, '/')) ?? $normalized;
        $normalized = ltrim($normalized, '/');

        return $normalized !== '' ? $normalized : null;
    }
}
