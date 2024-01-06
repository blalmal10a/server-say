<?php

namespace App\Services;

use OwenIt\Auditing\Models\Audit;

class AuditService
{
    public function paginate($request)
    {
        $sortBy  = $request->sortBy;
        $page    = $request->page ? $request->page : 1;
        $order   = $request->descending === 'true' ? 'desc' : 'asc';
        $perPage = $request->rowsPerPage ? $request->rowsPerPage : 15;

        $query   = (new Audit())->newQuery();
        $query   = $query->with('user');

        $query->when($request->search, function ($query) use ($request) {
            $query->where('id', 'like', "%$request->search%");
            $query->orWhere('ip_address', 'like', "%$request->search%");
            $query->orWhere('auditable_type', 'like', "%$request->search%");
            $query->orWhere('user_agent', 'like', "%$request->search%");
            $query->orWhere('url', 'like', "%$request->search%");
            $query->orWhere('event', 'like', "%$request->search%");
        });

        $query = $query->orderBy($sortBy, $order);
        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results, 200);
    }

    public function show($audit)
    {
        return $audit->load('user');
    }
}
