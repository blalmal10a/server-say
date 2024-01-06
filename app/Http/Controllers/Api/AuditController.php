<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuditService;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function __construct(private AuditService $service) {}

    public function index(Request $request)
    {
        return $this->service->paginate($request);
    }

    public function show(Audit $audit)
    {
        return $this->service->show($audit);
    }
}
