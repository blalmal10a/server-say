<?php

namespace App\Services;

use App\Models\Page;

class PageService
{
    public function paginate($request)
    {
        $sortBy  = $request->sortBy;
        $page    = $request->page ? $request->page : 1;
        $order   = $request->descending === 'true' ? 'desc' : 'asc';
        $perPage = $request->rowsPerPage ? $request->rowsPerPage : 15;

        $query   = (new Page())->newQuery();

        $query->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', "%$request->search%");
            $query->orWhere('slug', 'like', "%$request->search%");
            $query->orWhere('contents', 'like', "%$request->search%");
        });

        $query = $query->orderBy($sortBy, $order);
        $results = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($results, 200);
    }

    public function show($page)
    {
        return $page;
    }

    public function store($attributes) : Page
    {
        return Page::create($attributes);
    }

    public function update($page, $attributes) : Page
    {
        $page->update($attributes);
        return $page;
    }

    public function destroy($page)
    {
        return $page->delete();
    }
}
