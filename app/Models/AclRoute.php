<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use OwenIt\Auditing\Auditable as AuditingAuditable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasPermissions;

class AclRoute extends Model implements Auditable
{
    use HasFactory, HasPermissions, AuditingAuditable;

    protected $fillable = [
        'name',
    ];

    public static function getRoutes()
    {
        $routes = [];

        foreach (Route::getRoutes() as $route) {
            if (strpos($route->uri, 'api') !== 0) {
                continue;
            }

            if (!isset($route->action['as'])) {
                continue;
            }

            $actions = explode('.', $route->action['as']);

            $module = $actions[0];
            $name = $actions[1];

            if (in_array($module, ['acl', 'auth', 'app', 'sanctum'])) {
                continue;
            }

            if (!isset($routes[$module])) {
                $routes[$module] = [];
            }

            $aclRoute = AclRoute::firstOrCreate(['name' => $module . '.' . $name]);
            $routes[$module][] = $aclRoute;
        }

        return $routes;
    }
}
