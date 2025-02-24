<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * This middleware will be assigned to every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Http\Middleware\SetCacheHeaders::class,  // Set cache headers
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,  // Maintenance mode handling
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,  // Validate post size
        \App\Http\Middleware\ConvertEmptyStringsToNull::class,  // Convert empty strings to null
        \Illuminate\Http\Middleware\HandleCors::class,  // Cross-origin resource sharing (CORS) handling
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,  // CSRF protection
        \Illuminate\Session\Middleware\StartSession::class,  // Session handling
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,  // Share errors from session
        \Illuminate\Routing\Middleware\SubstituteBindings::class,  // Route model binding
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,  // Encrypt cookies
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,  // Add cookies to response
            \Illuminate\Session\Middleware\StartSession::class,  // Start session
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,  // Share errors
            \Illuminate\Routing\Middleware\SubstituteBindings::class,  // Route model binding
        ],

        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,  // Ensure frontend requests are stateful (if using Sanctum)
            \Illuminate\Routing\Middleware\SubstituteBindings::class,  // Route model binding for API
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,  // Authentication middleware
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,  // Basic auth middleware
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,  // Route model binding
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,  // Set cache headers
        'can' => \Illuminate\Auth\Middleware\Authorize::class,  // Check if user can perform action
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,  // Redirect if user is authenticated
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,  // Validate signed URLs
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,  // Throttle requests
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,  // Ensure email is verified
    ];
}
