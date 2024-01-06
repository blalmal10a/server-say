<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    public function getAllRoles()
    {
        return Role::where('id', '!=', 1)->get();
    }

    public function paginate($request)
    {
        $sortBy     = $request->sortBy;
        $page       = $request->page ? $request->page : 1;
        $order      = $request->descending === 'true' ? 'desc' : 'asc';
        $perPage    = $request->rowsPerPage ? $request->rowsPerPage : 15;

        $query      = (new Role())->newQuery();
        $query      = $query->whereNotIn('id', [1]);
        $query      = $query->with('permissions');

        $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', "%$request->search%");
        });

        $query      = $query->orderBy($sortBy, $order);
        $results    = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results, 200);
    }

    public function show($role) : Role
    {
        return $role;
    }

    public function store($attributes) : Role
    {
        $attributes['guard_name'] = 'web';

        $role = Role::create($attributes);
        $role->syncPermissions($attributes['permissions']);

        return $role;
    }

    public function update($role, $attributes) : Role
    {
        $role->update($attributes);
        $role->syncPermissions($attributes['permissions']);
        return $role;
    }

    public function destroy($role)
    {
        return $role->delete();
    }
}
