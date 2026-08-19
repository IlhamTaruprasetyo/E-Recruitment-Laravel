<?php

namespace App\Providers;

use App\Models\Department;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['frontend.*', 'frontend.components.footer', 'frontend.components.navbar'], function ($view) {
            $footerDepartments = Department::withCount(['jobs' => fn($q) => $q->where('status', 'Open')])
                ->take(5)
                ->get();
            
            $mainCompany = \App\Models\Company::where('name', 'like', '%Mitra Karya Analitika%')
                ->orWhere('name', 'like', '%MIKA%')
                ->first() ?? \App\Models\Company::first();

            $view->with([
                'footerDepartments' => $footerDepartments,
                'mainCompany' => $mainCompany,
            ]);
        });
    }
}
