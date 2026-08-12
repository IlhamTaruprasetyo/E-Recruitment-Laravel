<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\TestAttempt;
use App\Models\TestAnswer;
use App\Models\QuestionBank;
use App\Models\QuestionOption;
use App\Services\DiscCalculatorService;
use Illuminate\Support\Facades\DB;

$jobApp = DB::table('job_applications')->first();

if (!$jobApp) {
    echo "Creating mock job application...\n";
    $user = DB::table('users')->where('role_id', 3)->first();
    $job = DB::table('jobs')->first();
    if (!$user || !$job) {
        echo "Run php artisan db:seed first.\n";
        exit(1);
    }

    $profileId = DB::table('applicant_profile')->insertGetId([
        'user_id' => $user->id,
        'nik' => '3374000011112222',
        'full_name' => 'Ilham Taruprasetyo',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $jobAppId = DB::table('job_applications')->insertGetId([
        'profile_id' => $profileId,
        'job_id' => $job->id,
        'status' => 'applied',
        'applied_at' => now(),
    ]);
} else {
    $jobAppId = $jobApp->id;
}

$test = DB::table('tests')->first();
if (!$test) {
    $catId = DB::table('test_categories')->insertGetId(['name' => 'DISC Psikotes', 'created_at' => now(), 'updated_at' => now()]);
    $testId = DB::table('tests')->insertGetId([
        'job_id' => DB::table('jobs')->first()->id,
        'category_id' => $catId,
        'title' => 'Tes DISC Psikotes',
        'duration_minutes' => 30,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
} else {
    $testId = $test->id;
}

$attempt = TestAttempt::create([
    'job_application_id' => $jobAppId,
    'test_id' => $testId,
    'status' => 'completed',
]);

echo "Testing DiscCalculatorService for Attempt ID: {$attempt->id}\n";

$catId = DB::table('test_categories')->first()?->id ?? 1;

// Create mock question & options
$question = QuestionBank::create([
    'category_id' => $catId,
    'question' => 'Gambaran Kepribadian',
    'question_type' => 'disc'
]);

$optD = QuestionOption::create(['question_id' => $question->id, 'option_text' => 'Gambaran D', 'attribute_tag' => 'D']);
$optI = QuestionOption::create(['question_id' => $question->id, 'option_text' => 'Gambaran I', 'attribute_tag' => 'I']);
$optS = QuestionOption::create(['question_id' => $question->id, 'option_text' => 'Gambaran S', 'attribute_tag' => 'S']);
$optC = QuestionOption::create(['question_id' => $question->id, 'option_text' => 'Gambaran C', 'attribute_tag' => 'C']);

// Mock 10 Most D answers
for ($i = 0; $i < 10; $i++) {
    TestAnswer::create([
        'attempt_id' => $attempt->id,
        'question_id' => $question->id,
        'option_id' => $optD->id,
        'answer_type' => 'most'
    ]);
}
// Mock 5 Most I answers
for ($i = 0; $i < 5; $i++) {
    TestAnswer::create([
        'attempt_id' => $attempt->id,
        'question_id' => $question->id,
        'option_id' => $optI->id,
        'answer_type' => 'most'
    ]);
}
// Mock 10 Least C answers
for ($i = 0; $i < 10; $i++) {
    TestAnswer::create([
        'attempt_id' => $attempt->id,
        'question_id' => $question->id,
        'option_id' => $optC->id,
        'answer_type' => 'least'
    ]);
}

$calculator = new DiscCalculatorService();
$result = $calculator->calculate($attempt);

echo "=== DISC CALCULATION RESULT ===\n";
echo "Attempt ID: " . $result->test_attempt_id . "\n";
echo "Profile ID: " . $result->disc_profiles_id . "\n";
echo "Profile Code: " . ($result->discProfile?->pattern_code ?? 'N/A') . "\n";
echo "Profile Title: " . ($result->discProfile?->title ?? 'N/A') . "\n";
echo "Line 1 Scores (Most): " . json_encode($result->line_1_scores) . "\n";
echo "Line 2 Scores (Least): " . json_encode($result->line_2_scores) . "\n";
echo "Line 3 Scores (Diff): " . json_encode($result->line_3_scores) . "\n";
echo "SUCCESS!\n";
