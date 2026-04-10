<?php
/**
 * ⚠️ DELETE THIS FILE AFTER USE! ⚠️
 * URL: https://baancream.after-spa.com/diagnose.php
 */

echo '<pre style="font-family:monospace;font-size:12px;background:#1e1e1e;color:#d4d4d4;padding:20px;white-space:pre-wrap;word-break:break-all;">';
echo "=== BaanCream Diagnostic Script ===\n";
echo "Time: " . date('Y-m-d H:i:s') . "\n\n";

// 1. PHP version
echo "📌 PHP Version: " . PHP_VERSION . "\n\n";

// 2. Check key files exist
echo "📁 File Existence Check:\n";
$files = [
    'app/Http/Controllers/Admin/SiteSettingController.php',
    'app/Models/SiteSetting.php',
    'database/migrations/2026_04_10_120000_create_site_settings_table.php',
    'resources/views/admin/settings/edit.blade.php',
    'resources/views/layouts/admin.blade.php',
];
foreach ($files as $f) {
    $fullPath = __DIR__ . '/../' . $f;
    $exists = file_exists($fullPath) ? '✅' : '❌';
    echo "  {$exists} {$f}\n";
}
echo "\n";

// 3. Bootstrap Laravel
echo "🚀 Bootstrapping Laravel...\n";
try {
    define('LARAVEL_START', microtime(true));
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "✅ Laravel bootstrapped OK\n\n";
} catch (\Throwable $e) {
    echo "❌ Bootstrap failed: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . " Line: " . $e->getLine() . "\n\n";
    echo '</pre>';
    exit;
}

// 4. Check DB connection and tables
echo "🗄️  Database Check:\n";
try {
    $pdo = DB::connection()->getPdo();
    echo "✅ DB connected: " . DB::connection()->getDatabaseName() . "\n";
    
    $tables = ['users', 'site_settings', 'cache', 'sessions', 'products', 'orders'];
    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "  ✅ {$table} ({$count} rows)\n";
        } catch (\Exception $e) {
            echo "  ❌ {$table} → " . $e->getMessage() . "\n";
        }
    }
} catch (\Exception $e) {
    echo "❌ DB failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 5. Check Cache works
echo "💾 Cache Check (CACHE_STORE=" . config('cache.default') . "):\n";
try {
    Cache::put('diag_test', 'ok', 10);
    $val = Cache::get('diag_test');
    echo ($val === 'ok') ? "✅ Cache read/write OK\n" : "❌ Cache read failed\n";
} catch (\Exception $e) {
    echo "❌ Cache error: " . $e->getMessage() . "\n";
}
echo "\n";

// 6. Test SiteSetting model
echo "⚙️  SiteSetting Model Test:\n";
try {
    $val = \App\Models\SiteSetting::getValue('storefront_logo', null);
    echo "✅ getValue() OK → " . ($val ? "has value: {$val}" : "null (no logo set)") . "\n";
    $url = \App\Models\SiteSetting::publicUrl('storefront_logo');
    echo "✅ publicUrl() OK → " . ($url ?? 'null') . "\n";
} catch (\Exception $e) {
    echo "❌ SiteSetting error: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
echo "\n";

// 7. Check routes
echo "🛣️  Route Check:\n";
try {
    $settingsRoute = route('admin.settings.edit');
    echo "✅ admin.settings.edit → {$settingsRoute}\n";
    $updateRoute = route('admin.settings.update');
    echo "✅ admin.settings.update → {$updateRoute}\n";
    $logoRoute = route('branding.logo');
    echo "✅ branding.logo → {$logoRoute}\n";
} catch (\Exception $e) {
    echo "❌ Route error: " . $e->getMessage() . "\n";
}
echo "\n";

// 8. Check storage config
echo "📂 Storage Check:\n";
echo "  FILESYSTEM_DISK: " . config('filesystems.default') . "\n";
$publicRoot = config('filesystems.disks.public.root');
echo "  public disk root: {$publicRoot}\n";
echo "  writable: " . (is_writable($publicRoot) ? '✅' : '❌') . "\n";

$symlinkPath = public_path('storage');
echo "  public/storage symlink: " . (is_link($symlinkPath) ? '✅ exists' : (is_dir($symlinkPath) ? '⚠️ dir (not symlink)' : '❌ missing')) . "\n";
echo "\n";

// 9. Recent Laravel log tail
echo "📋 Laravel Log (last 30 lines):\n";
echo str_repeat('-', 50) . "\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lines = file($logFile);
    $last = array_slice($lines, max(0, count($lines) - 30));
    echo implode('', $last);
} else {
    echo "No log file found.\n";
}

echo "\n\n✅ Diagnostic complete. DELETE THIS FILE NOW!\n";
echo '</pre>';
