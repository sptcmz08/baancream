<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SiteSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_storefront_logo(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $pngImage = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9sZrxhQAAAAASUVORK5CYII=');

        $response = $this->actingAs($admin)->put(route('admin.settings.update'), [
            'storefront_logo' => UploadedFile::fake()->createWithContent('logo.png', $pngImage),
        ]);

        $response->assertRedirect(route('admin.settings.edit'));

        $storedPath = SiteSetting::getValue('storefront_logo');

        $this->assertNotNull($storedPath);
        Storage::disk('public')->assertExists($storedPath);
        $this->get(route('home'))->assertSee(Storage::disk('public')->url($storedPath));
    }
}
