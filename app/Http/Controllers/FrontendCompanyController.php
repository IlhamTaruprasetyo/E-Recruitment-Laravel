<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class FrontendCompanyController extends Controller
{
    /**
     * Display the specified company profile detail page.
     */
    public function show(string $id)
    {
        $company = Company::with(['departments'])->findOrFail($id);

        // Ambil lowongan aktif khusus perusahaan ini
        $activeJobs = $company->jobs()
            ->active()
            ->with(['department', 'position', 'degrees'])
            ->latest('id')
            ->get();

        // Ambil entitas grup perusahaan lainnya untuk navigasi eksplorasi cepat
        $otherCompanies = Company::where('id', '!=', $company->id)
            ->orderBy('id', 'asc')
            ->take(4)
            ->get();

        return view('frontend.companies.show', compact('company', 'activeJobs', 'otherCompanies'));
    }
}
