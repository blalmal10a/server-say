<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AclRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoutesController extends Controller
{
    public function all()
    {
        return AclRoute::getRoutes();
    }

    public function updatePermissionRoutes(Request $request, $permissionId)
    {
        DB::table('model_has_permissions')
            ->where('model_type', AclRoute::class)
            ->where('permission_id', $permissionId)
            ->delete();

        $insert = [];
        foreach($request->input('routes') as $routeId) {
            $insert[] = [
                'model_id' => $routeId,
                'model_type' => AclRoute::class,
                'permission_id' => $permissionId,
            ];
        }

        DB::table('model_has_permissions')->insert($insert);
    }

    public function getPermissionRoutes($permissionId)
    {
        return DB::table('model_has_permissions')
                ->where('model_type', AclRoute::class)
                ->where('permission_id', $permissionId)
                ->get()
                ->map(function($item) {
                    return $item->model_id;
                });
    }
}
