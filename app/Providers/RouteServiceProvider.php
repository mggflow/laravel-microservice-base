<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use MGGFLOW\LVMSVC\Routes\ConfigureRateLimiting;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

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
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        ConfigureRateLimiting::configure();

        $this->routes(function () {
            Route::prefix(static::genApiPrefix())
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::prefix($this->getRootPrefix())
                ->middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
