<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

App\Models\Job::query()->update(['status' => 'Open']);
echo "Updated all jobs status to 'Open'\n";
