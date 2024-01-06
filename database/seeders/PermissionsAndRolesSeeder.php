<?php

namespace Database\Seeders;

use App\Models\AclRoute;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->makeRoles();
        $firstUser = User::first();

        foreach ($this->getPermissions() as $roleName => $permissions) {
            $firstUser->assignRole($roleName);

            foreach ($permissions as $permissionName) {
                $p = Permission::firstOrCreate(['guard_name' => 'web', 'name' => $permissionName]);
                $firstUser->givePermissionTo($p);

                $this->{strtolower(trim($roleName, ' '))}->givePermissionTo($p);

                if ($roleName != 'Devs') {
                    $this->devs->givePermissionTo($p);
                }
            }
        }

        AclRoute::getRoutes();
        $allRoutes = AclRoute::get()->keyBy('name');

        $routePermissions = [];
        $allPermissions = Permission::where('guard_name', 'web')->get()->keyBy('name');

        foreach ($this->getRoutePermissions() as $permission => $routes) {
            foreach ($routes as $route) {
                $routePermissions[] = [
                    'model_type' => AclRoute::class,
                    'model_id' => $allRoutes[$route]->id,
                    'permission_id' => $allPermissions[$permission]->id,
                ];
            }
        }

        DB::table('model_has_permissions')->insert($routePermissions);
    }

    public function makeRoles()
    {
        $this->devs = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'Devs']);
        $this->admin = Role::firstOrCreate(['guard_name' => 'web', 'name' => 'Admin']);
    }

    public function getPermissions()
    {
        return [
            'Devs' => [
                'view users',
                'manage users',

                'view pages',
                'manage pages',

                'view roles',
                'manage roles',

                'view permissions',
                'manage permissions',

                'view audits',
            ],

            'Admin' => [
                'view users',
                'manage users',

                'view pages',
                'manage pages',

                'view roles',
                'manage roles',

                'view permissions',
                'manage permissions',

                'view audits',
            ],
        ];
    }

    protected function getRoutePermissions()
    {
        return [
            'view users' => [
                'users.index',
                'users.show',
            ],
            'manage users' => [
                'users.store',
                'users.update',
                'users.destroy',
            ],

            'view pages' => [
                'pages.index',
                'pages.show',
            ],
            'manage pages' => [
                'pages.store',
                'pages.update',
                'pages.destroy',
            ],

            'view roles' => [
                'roles.all',
                'roles.show',
                'roles.paginate',
            ],
            'manage roles' => [
                'roles.store',
                'roles.update',
                'roles.destroy',
            ],

            'view permissions' => [
                'permissions.all',
                'permissions.show',
                'permissions.paginate',
            ],
            'manage permissions' => [
                'permissions.store',
                'permissions.update',
                'permissions.destroy',
                'permissions.mappings',
            ],

            'view audits' => [
                'audits.show',
                'audits.index',
            ],
        ];
    }
}
