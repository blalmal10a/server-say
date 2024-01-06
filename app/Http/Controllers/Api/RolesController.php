<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    public function __construct(private RoleService $service) {}

    public function all()
    {
        return $this->service->getAllRoles();
    }

    public function paginate(Request $request)
    {
        return $this->service->paginate($request);
    }

    public function store(RoleRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function show(Role $role)
    {
        return $this->service->show($role);
    }

    public function update(RoleRequest $request, Role $role)
    {
        return $this->service->update($role, $request->all());
    }

    public function destroy(Role $role)
    {
        return $this->service->destroy($role);
    }
}
