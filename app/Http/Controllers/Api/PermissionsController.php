<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    public function __construct(private PermissionService $service) {}

    public function all()
    {
        return $this->service->getAllPermissions();
    }

    public function paginate(Request $request)
    {
        return $this->service->paginate($request);
    }

    public function store(PermissionRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function show(Permission $permission)
    {
        return $this->service->show($permission);
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        return $this->service->update($permission, $request->all());
    }

    public function destroy(Permission $permission)
    {
        return $this->service->destroy($permission);
    }
}
