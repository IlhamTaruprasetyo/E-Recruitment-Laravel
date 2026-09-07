<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Job;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the dynamic About Us page (Tentang Kami).
     */
    public function index()
    {
        // Prioritas ambil PT Mitra Karya Analitika, atau fallback ke record Company pertama
        $company = Company::where('name', 'like', '%Mitra Karya Analitika%')
            ->orWhere('name', 'like', '%MIKA%')
            ->first() ?? Company::first();

        // Ambil entitas grup perusahaan lainnya secara dinamis (selain PT Mitra Karya Analitika)
        $groupCompanies = Company::when($company, fn($q) => $q->where('id', '!=', $company->id))
            ->where('name', '!=', 'PT Mitra Karya Analitika')
            ->where('name', 'not like', '%Mitra Karya Analitika%')
            ->orderBy('id', 'asc')
            ->get();

        // Data pendukung statistik dan CTA
        $totalJobsCount = Job::active()->count();
        $departmentsCount = Department::count();
        $departments = Department::withCount(['jobs' => function ($q) {
            $q->active();
        }])->take(6)->get();

        return view('frontend.about.index', compact(
            'company',
            'groupCompanies',
            'totalJobsCount',
            'departmentsCount',
            'departments'
        ));
    }
}
