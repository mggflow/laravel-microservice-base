<?php

namespace App\Providers;

use App\Microservice\Exceptions\TooManyRequests;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
     protected $namespace = 'App\Microservice\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->map();
        });
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
        // If app not in root directory need to correct prefix
        Route::prefix(env('ROOT_PREFIX',''))
            ->middleware('web')
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless but...
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        // If app not in root directory need to correct prefix
        Route::prefix(env('ROOT_PREFIX','').'api')
            ->middleware([
                'throttle:api',
                'msvc_cookies_encrypter',
                'msvc_cookies_decoder',
                'msvc_cookies_handler',
                'msvc_preparation',
                'msvc_response_encoder',
                'msvc_validation',
                'msvc_mapping',
                'msvc_auth',
                'api',
            ])
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(128)->by($request->ip())->response(function (){
                throw new TooManyRequests();
            });
        });
    }
}
