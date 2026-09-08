<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    /**
     * Display the About Us (Tentang Kami) page.
     */
    public function index()
    {
        // Prioritas ambil PT Mitra Karya Analitika, atau fallback ke record Company pertama
        $company = Cache::remember('frontend_main_company', 86400, function () {
            return Company::where('name', 'like', '%Mitra Karya Analitika%')
                ->orWhere('name', 'like', '%MIKA%')
                ->first() ?? Company::first();
        });

        // Ambil entitas grup perusahaan lainnya secara dinamis (selain PT Mitra Karya Analitika)
        $groupCompanies = Cache::remember('about_group_companies', 86400, function () use ($company) {
            return Company::when($company, fn($q) => $q->where('id', '!=', $company->id))
                ->where('name', '!=', 'PT Mitra Karya Analitika')
                ->where('name', 'not like', '%Mitra Karya Analitika%')
                ->orderBy('id', 'asc')
                ->get();
        });

        // Data pendukung statistik dan CTA
        $totalJobsCount = Cache::remember('home_total_jobs_count', 3600, fn() => Job::active()->count());
        $departmentsCount = Cache::remember('home_departments_count', 86400, fn() => Department::count());
        $departments = Cache::remember('about_departments_with_jobs', 3600, function () {
            return Department::withCount(['jobs' => function ($q) {
                $q->active();
            }])->take(6)->get();
        });

        return view('frontend.about.index', compact(
            'company',
            'groupCompanies',
            'totalJobsCount',
            'departmentsCount',
            'departments'
        ));
    }
}
