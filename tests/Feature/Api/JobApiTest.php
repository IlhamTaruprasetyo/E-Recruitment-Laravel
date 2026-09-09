<?php

use App\Models\Company;
use App\Models\Department;
use App\Models\Job;
use Carbon\Carbon;

beforeEach(function () {
    $this->company = Company::create([
        'name' => 'PT Teknologi Nusantara',
        'city' => 'Jakarta Selatan',
        'province' => 'DKI Jakarta',
    ]);

    $this->department = Department::create([
        'company_id' => $this->company->id,
        'name' => 'Engineering',
    ]);
});

test('it returns active open jobs via API v1', function () {
    // 1. Job yang aktif (status Open, deadline masih lama)
    $openJob = Job::create([
        'company_id' => $this->company->id,
        'department_id' => $this->department->id,
        'title' => 'Senior Fullstack Developer',
        'description' => 'Mengembangkan aplikasi Next.js dan Nuxt.js',
        'employment_type' => 'Full-time',
        'location' => 'Jakarta (Hybrid)',
        'salary_min' => 12000000,
        'salary_max' => 18000000,
        'quota' => 2,
        'deadline' => Carbon::now()->addDays(14)->toDateString(),
        'status' => 'Open',
    ]);

    // 2. Job yang berstatus Closed (tidak boleh muncul)
    Job::create([
        'company_id' => $this->company->id,
        'department_id' => $this->department->id,
        'title' => 'Closed Job Position',
        'description' => 'Lowongan sudah ditutup',
        'employment_type' => 'Full-time',
        'location' => 'Jakarta',
        'quota' => 1,
        'deadline' => Carbon::now()->addDays(14)->toDateString(),
        'status' => 'Closed',
    ]);

    // 3. Job yang sudah kedaluwarsa (deadline kemarin)
    Job::create([
        'company_id' => $this->company->id,
        'department_id' => $this->department->id,
        'title' => 'Expired Job Position',
        'description' => 'Lowongan sudah expired',
        'employment_type' => 'Full-time',
        'location' => 'Jakarta',
        'quota' => 1,
        'deadline' => Carbon::now()->subDay()->toDateString(),
        'status' => 'Open',
    ]);

    $response = $this->getJson('/api/v1/jobs');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'employment_type',
                    'location',
                    'salary' => ['min', 'max', 'currency', 'formatted'],
                    'quota',
                    'description',
                    'deadline',
                    'status',
                    'apply_url',
                    'deadline_info' => ['is_expired', 'is_active', 'days_remaining', 'badge'],
                    'company' => ['id', 'name'],
                    'department' => ['id', 'name'],
                ]
            ],
            'meta' => ['current_page', 'per_page', 'total_items', 'total_pages'],
            'links' => ['first', 'last', 'prev', 'next'],
        ]);

    // Hanya 1 lowongan yang boleh muncul
    expect($response->json('meta.total_items'))->toBe(1);
    expect($response->json('data.0.title'))->toBe('Senior Fullstack Developer');
});

test('it filters jobs by search keyword and location', function () {
    Job::create([
        'company_id' => $this->company->id,
        'department_id' => $this->department->id,
        'title' => 'Frontend React Developer',
        'description' => 'Fokus pada Next.js',
        'employment_type' => 'Full-time',
        'location' => 'Bandung',
        'quota' => 1,
        'deadline' => Carbon::now()->addDays(10)->toDateString(),
        'status' => 'Open',
    ]);

    Job::create([
        'company_id' => $this->company->id,
        'department_id' => $this->department->id,
        'title' => 'Backend Laravel Developer',
        'description' => 'Fokus pada REST API',
        'employment_type' => 'Full-time',
        'location' => 'Surabaya',
        'quota' => 1,
        'deadline' => Carbon::now()->addDays(10)->toDateString(),
        'status' => 'Open',
    ]);

    $searchResponse = $this->getJson('/api/v1/jobs?q=React');
    $searchResponse->assertStatus(200);
    expect($searchResponse->json('meta.total_items'))->toBe(1);
    expect($searchResponse->json('data.0.title'))->toBe('Frontend React Developer');

    $locationResponse = $this->getJson('/api/v1/jobs?location=Surabaya');
    $locationResponse->assertStatus(200);
    expect($locationResponse->json('meta.total_items'))->toBe(1);
    expect($locationResponse->json('data.0.title'))->toBe('Backend Laravel Developer');
});

test('it returns detail of an active job', function () {
    $job = Job::create([
        'company_id' => $this->company->id,
        'department_id' => $this->department->id,
        'title' => 'DevOps Engineer',
        'description' => 'CI/CD dan Cloud Architect',
        'employment_type' => 'Full-time',
        'location' => 'Jakarta',
        'quota' => 1,
        'deadline' => Carbon::now()->addDays(20)->toDateString(),
        'status' => 'Open',
    ]);

    $response = $this->getJson("/api/v1/jobs/{$job->id}");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'id' => $job->id,
                'title' => 'DevOps Engineer',
            ],
        ]);
});

test('it returns 404 for non-existent or closed job detail', function () {
    $closedJob = Job::create([
        'company_id' => $this->company->id,
        'department_id' => $this->department->id,
        'title' => 'Closed Position',
        'description' => 'Closed',
        'employment_type' => 'Full-time',
        'location' => 'Jakarta',
        'quota' => 1,
        'deadline' => Carbon::now()->addDays(5)->toDateString(),
        'status' => 'Closed',
    ]);

    $response = $this->getJson("/api/v1/jobs/{$closedJob->id}");
    $response->assertStatus(404)
        ->assertJson(['success' => false]);
});
