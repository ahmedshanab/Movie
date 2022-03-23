<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';
    protected $namespace_front = 'App\Http\Controllers\front';
    protected $dashboard_namespace = 'App\Http\Controllers\dashboard';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';
    public const DASHBOARD = '/dashboard';
    public const FRONT = '/front';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        // defined it only for dashboard/web.php
        $this->mapWebDashboard();
        $this->mapWebFront();
        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapWebFront()
    {
        Route::middleware('web')
            ->namespace($this->namespace_front)
            ->group(base_path('routes/front/web.php'));
    }

    // defined it only for dashboard
    protected function mapWebDashboard()
    {
        Route::middleware('web')
             ->namespace($this->dashboard_namespace)
             ->group(base_path('routes/dashboard/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
