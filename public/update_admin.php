<?php
/**
 * Update admin credentials: username=admin, password=password
 * DELETE this file immediately after use!
 */

define('LARAVEL_START', microtime(true));
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $admin = User::where('role', 'admin')->first();

    if (!$admin) {
        echo "❌ ไม่พบ admin user ในระบบ";
        exit;
    }

    $admin->username = 'admin';
    $admin->password = Hash::make('password');
    $admin->save();

    echo "✅ อัพเดต admin สำเร็จ<br>";
    echo "Username: <strong>admin</strong><br>";
    echo "Password: <strong>password</strong><br>";
    echo "<br>⚠️ <strong style='color:red'>ลบไฟล์นี้ทิ้งทันที!</strong>";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
