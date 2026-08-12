<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::with('role', 'applicantProfile')->get();
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role ID: {$user->role_id} | Role Name: " . ($user->role->name ?? 'NULL') . " | Has Profile: " . ($user->applicantProfile ? 'YES' : 'NO') . "\n";
}
