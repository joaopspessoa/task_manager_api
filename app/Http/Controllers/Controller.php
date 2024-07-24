<?php

namespace App\Http\Controllers;

use App\Services\Service;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Classe base para os controladores da aplicação.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var Service $service Serviço genérico injetado via construtor.
     */
    protected Service $service;

    /**
     * Construtor da classe Controller.
     *
     * @param Service $service Serviço genérico.
     */
    public function __construct(Service $service)
    {
        // Injeta o serviço genérico na classe.
        $this->service = $service;
    }

    /**
     * Retorna o serviço injetado.
     *
     * @return Service Serviço injetado na classe.
     */
    public function service()
    {
        return $this->service;
    }
}
