<?php

namespace App\Services;

use App\Jobs\AssignUserRolesAndPermissions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PaginateService
{



    public function __invoke($request, $query)
    {
        $sortBy     = $request->sortBy ?? 'created_at';
        $page       = $request->page ? $request->page : 1;
        $order      = $request->descending === 'false' ? 'asc' : 'desc';
        $perPage    = $request->rowsPerPage ? $request->rowsPerPage : PHP_INT_MAX;
        $query      = $query->orderBy($sortBy ?: 'created_at', $order ?? 'desc');
        $results    = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results, 200);
    }
}
