<?php

namespace App\Http\Controllers;

use App\Services\AppService;
use Illuminate\Support\Collection;

class AppController extends Controller
{
    public function __invoke() : Collection
    {
        return AppService::getPublicInformation();
    }
}
