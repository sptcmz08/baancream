<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'storefrontLogoPath' => SiteSetting::getValue('storefront_logo'),
            'storefrontLogoUrl' => SiteSetting::publicUrl('storefront_logo'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'storefront_logo' => 'nullable|image|max:4096',
            'remove_storefront_logo' => 'nullable|boolean',
        ]);

        $currentLogoPath = SiteSetting::getValue('storefront_logo');

        if ($request->boolean('remove_storefront_logo') && $currentLogoPath) {
            Storage::disk('public')->delete($currentLogoPath);
            SiteSetting::forgetValue('storefront_logo');
            $currentLogoPath = null;
        }

        if ($request->hasFile('storefront_logo')) {
            if ($currentLogoPath) {
                Storage::disk('public')->delete($currentLogoPath);
            }

            $storedPath = $request->file('storefront_logo')->store('site-settings', 'public');

            SiteSetting::setValue('storefront_logo', $storedPath);
        }

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'อัปเดตโลโก้เว็บไซต์สำเร็จ');
    }

    public function showStorefrontLogo(): BinaryFileResponse
    {
        $path = SiteSetting::getValue('storefront_logo');

        abort_unless($path && Storage::disk('public')->exists($path), 404);

        return response()->file(
            Storage::disk('public')->path($path),
            ['Cache-Control' => 'public, max-age=86400']
        );
    }
}
