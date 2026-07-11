<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Intern;
use App\Models\Invoice;
use App\Models\Leave;
use App\Models\Quote;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();

        if (! $this->app->runningInConsole() && request()->isSecure()) {
            URL::forceScheme('https');
        }

        View::composer('dashboard.common', function ($view) {
            $view->with('total_employees', Employee::where('status', 0)->count());
            $view->with('total_interns',    Intern::count());
            $view->with('total_clients',    Client::where('is_delete', 0)->count());
            $view->with('total_quotes',     Quote::count());
            $view->with('total_invoices',   Invoice::count());
            $view->with('pending_leaves',   Leave::where('status', 'pending')->count());
            $view->with('userType',         optional(Auth::user())->user_type);
        });
    }
}
