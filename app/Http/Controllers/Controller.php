<?php

namespace App\Http\Controllers;

use App\Services\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function service()
    {
        return $this->service;
    }
}
