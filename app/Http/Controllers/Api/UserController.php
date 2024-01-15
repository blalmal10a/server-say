<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
// use MongoDB\Laravel\Auth\User;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }

    public function index(Request $request)
    {
        return $this->service->paginate($request);
    }

    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());
        $user->designations()->attach(request('designations'));
        return $this->index(request());
    }

    public function show(User $user)
    {

        return $user;
        // return $this->service->show($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->service->update($user, $request->all());
        return $this->index(request());
    }

    public function destroy(User $user)
    {
        $this->service->destroy($user);
        return $this->index(request());
    }

    public function updateAccessControls(Request $request, User $user)
    {
        $user->syncRoles($request->input('roles'));
        $user->syncPermissions($request->input('permissions'));

        return 'ok';
    }
}
