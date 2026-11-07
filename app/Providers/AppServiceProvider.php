<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\EmployeeModel;
use App\Observers\EmployeeObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        EmployeeModel::observe(EmployeeObserver::class);
        // Bagikan data employee ke view sidebar secara otomatis setiap kali view tersebut dipanggil
        View::composer('layouts.app', function ($view) {
            $employee = null;

            if (Auth::check()) {
                // Mengambil relasi employee dari user yang sedang login
                $employee = Auth::user()->employee; 
            }

            $view->with('employee', $employee);
        });
    }
}
