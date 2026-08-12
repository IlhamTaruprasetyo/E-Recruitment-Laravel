<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jobs = App\Models\Job::all();
echo "--- JOBS --- \n";
foreach ($jobs as $j) {
    echo "Job ID: {$j->id} | Title: {$j->title} | Status: '{$j->status}' | Deadline: " . ($j->deadline ?? 'NULL') . "\n";
}

$apps = App\Models\JobApplication::with('job')->get();
echo "\n--- JOB APPLICATIONS --- \n";
foreach ($apps as $a) {
    echo "App ID: {$a->id} | Job ID: {$a->job_id} | Job Title: " . ($a->job->title ?? 'NULL') . " | Job Status: '" . ($a->job->status ?? 'NULL') . "' | Job Deadline: " . ($a->job->deadline ?? 'NULL') . " | App Status: {$a->status}\n";
}
