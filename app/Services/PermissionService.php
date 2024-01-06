<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    public function getAllPermissions()
    {
        return Permission::all();
    }

    public function paginate($request)
    {
        $sortBy  = $request->sortBy;
        $page    = $request->page ? $request->page : 1;
        $order   = $request->descending === 'true' ? 'desc' : 'asc';
        $perPage = $request->rowsPerPage ? $request->rowsPerPage : 15;

        $query   = (new Permission())->newQuery();

        $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', "%$request->search%");
        });

        $query = $query->orderBy($sortBy, $order);
        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results, 200);
    }

    public function show($permission) : Permission
    {
        return $permission;
    }

    public function store($attributes) : Permission
    {
        $attributes['guard_name'] = 'web';
        return Permission::create($attributes);
    }

    public function update($permission, $attributes) : Permission
    {
        $permission->update($attributes);
        return $permission;
    }

    public function destroy($permission)
    {
        return $permission->delete();
    }
}
