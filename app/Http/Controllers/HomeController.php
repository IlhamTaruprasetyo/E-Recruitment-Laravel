<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the dedicated Recruitment Home Page (Beranda).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $location = $request->query('location');

        $jobsQuery = Job::active()->with(['company', 'department', 'degrees', 'majors']);

        if ($search) {
            $jobsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('company', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($location) {
            $jobsQuery->where('location', 'like', "%{$location}%");
        }

        // 6 Featured Jobs for Home
        $featuredJobs = (clone $jobsQuery)->latest('id')->take(6)->get();
        $totalJobsCount = Job::active()->count();
        $companiesCount = Company::count();
        $departmentsCount = Department::count();
        $totalQuotaCount = Job::active()->sum('quota');
        
        $departments = Department::withCount(['jobs' => function ($q) {
            $q->active();
        }])->get();
        $companies = Company::all();

        return view('frontend.home.index', compact(
            'featuredJobs',
            'totalJobsCount',
            'companiesCount',
            'departmentsCount',
            'totalQuotaCount',
            'departments',
            'companies',
            'search',
            'location'
        ));
    }
}
