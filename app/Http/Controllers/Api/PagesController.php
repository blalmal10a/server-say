<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Models\Page;
use App\Services\PageService;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct(private PageService $service) {}

    public function index(Request $request)
    {
        return $this->service->paginate($request);
    }

    public function store(PageRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function show(Page $page)
    {
        return $this->service->show($page);
    }

    public function update(PageRequest $request, Page $page)
    {
        return $this->service->update($page, $request->all());
    }

    public function destroy(Page $page)
    {
        return $this->service->destroy($page);
    }
}
