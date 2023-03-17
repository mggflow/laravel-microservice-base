<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use MGGFLOW\LVMSVC\Routes\ConfigureRateLimiting;

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
        ConfigureRateLimiting::configure();

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

    public static function isApiRoute(): bool
    {
        $route = Route::current();
        if (empty($route)) return false;
        $uri = $route->uri();

        $expectedStart = static::genApiPrefix().'/';

        $matchPos = stripos($uri, $expectedStart);

        return $matchPos !== false and $matchPos < 2;
    }

    public static function genApiPrefix(): string
    {
        return ltrim(join('/', [static::getRootPrefix(), 'api']), '/');
    }

    public static function getRootPrefix(): string
    {
        return trim(config('msvc.root_prefix'), '/');
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
        // If app is not in root directory need to correct prefix
        Route::prefix($this->getRootPrefix())
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
        // If app is not in root directory need to correct prefix
        Route::prefix(static::genApiPrefix())
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
}
