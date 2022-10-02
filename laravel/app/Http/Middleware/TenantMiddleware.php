<?php

namespace App\Http\Middleware;


use App\Http\Controllers\ApiResponse;
use App\Services\TenantService;
use App\Tenant\TenantFacade;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {



        $tenant = $request->get('tenant') ?? null;
        if (!TenantFacade::isAdmin()) {
            $tenant = TenantService::getTenantByUserId(Auth::guard('api')->user()->id)->id ?? null;
        }

        if (!$tenant) return ApiResponse::returnForbbiden();

        TenantFacade::setTenant((int) $tenant);
        return $next($request);
    }
}
