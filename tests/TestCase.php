<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\DB::table('roles')->updateOrInsert(['id' => 1], ['name' => 'Admin']);
        \Illuminate\Support\Facades\DB::table('roles')->updateOrInsert(['id' => 2], ['name' => 'Recruiter']);
        \Illuminate\Support\Facades\DB::table('roles')->updateOrInsert(['id' => 3], ['name' => 'Applicant']);
    }
}
