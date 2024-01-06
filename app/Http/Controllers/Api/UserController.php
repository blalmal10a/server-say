<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service) {}

    public function index(Request $request)
    {
        return $this->service->paginate($request);
    }

    public function store(UserRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function show(User $user)
    {
        return $this->service->show($user);
    }

    public function update(UserRequest $request, User $user)
    {
        return $this->service->update($user, $request->all());
    }

    public function destroy(User $user)
    {
        return $this->service->destroy($user);
    }

    public function updateAccessControls(Request $request, User $user)
    {
        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($request->input('permissions'));

        return 'ok';
    }
}
