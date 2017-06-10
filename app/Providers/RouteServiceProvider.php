<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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

        $this->mapBackendRoutes();

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
            ->domain(env('APP_URL', 'www.maimaitree.com'))
            ->namespace($this->namespace."\\WEB")
            ->group(base_path('routes/web.php'));

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
            ->namespace($this->namespace."\\API")
            ->group(base_path('routes/api.php'));
    }

    protected function mapBackendRoutes()
    {
        Route::middleware('backend')
            ->prefix('backend')
            ->domain(env('BACKEND_DOMAIN', 'admin.maimaitree.com'))
            ->namespace($this->namespace."\\BACKEND")
            ->group(base_path('routes/backend.php'));

        /*Route::group([
            'domain' => env('BACKEND_DOMAIN', 'admin.maimaitree.com'),
            'middleware' => 'backend',
            'namespace' => $this->namespace."\\BACKEND",
        ], function ($router) {
            require base_path('routes/backend.php');
        });*/
    }
}
