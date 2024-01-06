<?php

namespace App\Services;

use App\Jobs\AssignUserRolesAndPermissions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function paginate($request)
    {
        $sortBy     = $request->sortBy;
        $page       = $request->page ? $request->page : 1;
        $order      = $request->descending === 'true' ? 'desc' : 'asc';
        $perPage    = $request->rowsPerPage ? $request->rowsPerPage : 15;

        $query      = (new User())->newQuery();
        $query      = $query->whereNotIn('id', [1, Auth::user()->id]);

        $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', "%$request->search%");
            $query->orWhere('email', 'like', "%$request->search%");
        });

        $query->when($request->role, function ($query) use ($request) {
            $query->role($request->role);
        });

        $query      = $query->with('roles');
        $query      = $query->orderBy($sortBy, $order);
        $results    = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results, 200);
    }

    public function show($user) : User
    {
        $user['roles'] = $user->roles;
        $user['permissions'] = $user->permissions;

        return $user;
    }

    public function store($attributes) : User
    {
        $user = User::create($attributes);
        AssignUserRolesAndPermissions::dispatch($user->id, $attributes['roles']);

        return $user;
    }

    public function update($user, $attributes) : User
    {
        if (array_key_exists('password', $attributes)) {
            $user->password = Hash::make($attributes['password']);
            $user->save();
        } else {
            $user->update($attributes);
        }

        return $user;
    }

    public function destroy($user)
    {
        return $user->delete();
    }
}
