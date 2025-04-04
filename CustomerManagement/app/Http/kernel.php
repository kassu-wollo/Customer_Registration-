<?php
namespace App\Http;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        // Other middlewares...
        'role.permission' => \App\Http\Middleware\RolePermissionMiddleware::class,
    ];
}
