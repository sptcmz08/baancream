<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploaded_media_can_be_served_without_storage_symlink(): void
    {
        Storage::fake('public');

        $path = UploadedFile::fake()->createWithContent(
            'sample.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9sZrxhQAAAAASUVORK5CYII=')
        )->store('products', 'public');

        $response = $this->get('/media/' . $path);

        $response->assertOk();
    }
}
