<?php
/**
 * ⚠️ DELETE THIS FILE AFTER USE! ⚠️
 * URL: https://baancream.after-spa.com/clear_routes.php
 */

define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<pre style="font-family:monospace;background:#1e1e1e;color:#d4d4d4;padding:20px;">';
echo "=== Clearing Route & Config Cache ===\n\n";

Artisan::call('route:clear');
echo "route:clear → " . trim(Artisan::output()) . "\n";

Artisan::call('config:clear');
echo "config:clear → " . trim(Artisan::output()) . "\n";

Artisan::call('cache:clear');
echo "cache:clear → " . trim(Artisan::output()) . "\n";

Artisan::call('view:clear');
echo "view:clear → " . trim(Artisan::output()) . "\n";

// Verify branding.logo route now exists
try {
    $url = route('branding.logo');
    echo "\n✅ SUCCESS! Route [branding.logo] → {$url}\n";
    echo "✅ branding page should work now!\n";
} catch (\Exception $e) {
    echo "\n❌ Still missing: " . $e->getMessage() . "\n";
}

echo "\n⚠️  DELETE THIS FILE NOW: /public/clear_routes.php\n";
echo '</pre>';
