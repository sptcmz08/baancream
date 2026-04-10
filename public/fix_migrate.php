<?php
/**
 * ⚠️  EMERGENCY SERVER FIX SCRIPT ⚠️
 * ลบไฟล์นี้ออกทันทีหลังจาก run เสร็จแล้ว!
 * DELETE THIS FILE IMMEDIATELY AFTER RUNNING!
 *
 * URL to run: https://baancream.after-spa.com/fix_migrate.php
 */

// ป้องกัน timeout
set_time_limit(120);

// --- Bootstrap Laravel ---
define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo '<pre style="font-family:monospace;background:#1e1e1e;color:#d4d4d4;padding:20px;">';
echo "=== BaanCream Server Fix Script ===\n\n";

// 1. Run migrations
echo "📦 Running: php artisan migrate --force\n";
echo str_repeat('-', 50) . "\n";

$exitCode = Artisan::call('migrate', ['--force' => true]);
echo Artisan::output();
echo "Exit code: {$exitCode}\n\n";

// 2. Create storage symlink
echo "🔗 Running: php artisan storage:link\n";
echo str_repeat('-', 50) . "\n";

$exitCode2 = Artisan::call('storage:link', ['--force' => true]);
echo Artisan::output();
echo "Exit code: {$exitCode2}\n\n";

// 3. Clear caches
echo "🧹 Clearing caches...\n";
echo str_repeat('-', 50) . "\n";

Artisan::call('cache:clear');
echo "Cache: " . trim(Artisan::output()) . "\n";

Artisan::call('config:clear');
echo "Config: " . trim(Artisan::output()) . "\n";

Artisan::call('view:clear');
echo "Views: " . trim(Artisan::output()) . "\n\n";

// 4. Check site_settings table
echo "🔍 Checking site_settings table...\n";
echo str_repeat('-', 50) . "\n";

try {
    $count = DB::table('site_settings')->count();
    echo "✅ site_settings table exists! ({$count} rows)\n\n";
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n\n";
}

// 5. Check storage/app/public directory
echo "📁 Checking storage directory permissions...\n";
echo str_repeat('-', 50) . "\n";

$storagePath = storage_path('app/public');
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0775, true);
    echo "✅ Created: {$storagePath}\n";
} else {
    echo "✅ Exists: {$storagePath}\n";
}

$siteSettingsPath = $storagePath . '/site-settings';
if (!is_dir($siteSettingsPath)) {
    mkdir($siteSettingsPath, 0775, true);
    echo "✅ Created: {$siteSettingsPath}\n";
} else {
    echo "✅ Exists: {$siteSettingsPath}\n";
}

$writable = is_writable($storagePath) ? '✅ Writable' : '❌ NOT Writable';
echo "Permission: {$writable}\n\n";

// 6. Check public/storage symlink
echo "🔗 Checking public/storage symlink...\n";
echo str_repeat('-', 50) . "\n";

$symlinkPath = public_path('storage');
if (is_link($symlinkPath)) {
    echo "✅ Symlink exists: {$symlinkPath}\n";
} elseif (is_dir($symlinkPath)) {
    echo "⚠️  Directory exists (not symlink): {$symlinkPath}\n";
} else {
    echo "❌ No symlink found at: {$symlinkPath}\n";
    echo "   Attempting to create...\n";
    try {
        $target = storage_path('app/public');
        symlink($target, $symlinkPath);
        echo "✅ Symlink created!\n";
    } catch (\Exception $e) {
        echo "❌ Failed: " . $e->getMessage() . "\n";
    }
}

echo "\n" . str_repeat('=', 50) . "\n";
echo "✅ Done! Delete this file now: /public/fix_migrate.php\n";
echo '</pre>';
