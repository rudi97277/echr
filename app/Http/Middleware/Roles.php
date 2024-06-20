<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Enums\RoleRouteEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user->role) {
            $roleRoutes = isset(RoleRouteEnum::ROUTE[$user->role]) ? RoleRouteEnum::ROUTE[$user->role] : null;
            if ($roleRoutes === null)
                return $next($request);
            else if (in_array($request->route()->getName(), $roleRoutes)) {
                return $next($request);
            } else if (count($roleRoutes) > 0) {
                return redirect()->route($roleRoutes[0])->withErrors(['route' => 'Tidak ada akses untuk membuka halaman! Dialihkan!']);
            } else
                return redirect()->route('worker.home');
        } else
            return redirect()->route('worker.home');
    }
}
