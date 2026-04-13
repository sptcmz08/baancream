<?php

namespace App\Http\Controllers;

use App\Support\MediaPath;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaController extends Controller
{
    public function show(string $path): BinaryFileResponse
    {
        $normalizedPath = MediaPath::normalize(urldecode($path));

        abort_unless($normalizedPath !== '' && $normalizedPath !== null, 404);

        $candidates = array_values(array_unique(array_filter([
            $normalizedPath,
            ltrim($normalizedPath, '/'),
        ])));

        foreach ($candidates as $candidate) {
            if (Storage::disk('public')->exists($candidate)) {
                return response()->file(
                    Storage::disk('public')->path($candidate),
                    ['Cache-Control' => 'public, max-age=86400']
                );
            }

            $publicStoragePath = $this->safePath(public_path('storage'), $candidate);
            if ($publicStoragePath) {
                return response()->file($publicStoragePath, ['Cache-Control' => 'public, max-age=86400']);
            }
        }

        abort(404);
    }

    private function safePath(string $root, string $path): ?string
    {
        $rootPath = realpath($root);

        if ($rootPath === false) {
            return null;
        }

        $targetPath = realpath($rootPath . DIRECTORY_SEPARATOR . ltrim($path, '/\\'));

        if ($targetPath === false || !is_file($targetPath)) {
            return null;
        }

        $rootPath = rtrim(str_replace('\\', '/', $rootPath), '/') . '/';
        $targetPath = str_replace('\\', '/', $targetPath);

        return str_starts_with($targetPath, $rootPath) ? $targetPath : null;
    }
}
