<?php

namespace App\Http\Middleware;

use App\Models\AclRoute;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckAcl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = Route::currentRouteName();
        if (!$aclRoute = AclRoute::where('name', $routeName)->first()) {
            return $next($request);
        }

        $user = Auth::user();
        $userPermissions = $user->permissions->pluck('id');

        $routePermissions = DB::table('model_has_permissions')
            ->where('model_id', $aclRoute->id)
            ->where('model_type', AclRoute::class)
            ->get()
            ->pluck('permission_id');

        if (!$routePermissions->intersect($userPermissions)->count()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized. Permission required: ' . $routePermissions], 403);
            }

            return redirect()->guest(route('login'));
        }

        return $next($request);
    }
}
