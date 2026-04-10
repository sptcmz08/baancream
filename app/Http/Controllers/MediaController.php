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
        }

        abort(404);
    }
}
