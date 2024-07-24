<?php

namespace App\Services;

use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

/**
 * Classe abstrata base para serviços.
 * 
 * Esta classe fornece uma estrutura básica para serviços que interagem com um repositório
 * específico. Ela define um repositório que é injetado no serviço e fornece métodos
 * para acessar o repositório.
 */
abstract class Service
{
    /**
     * Instância do repositório associado ao serviço.
     * 
     * @var Repository
     */
    protected Repository $repository;

    /**
     * Construtor da classe.
     * 
     * Inicializa o serviço com o repositório fornecido.
     * 
     * @param Repository $repository O repositório a ser utilizado pelo serviço.
     */
    public function __construct(Repository $repository)
    {
        // Define o repositório associado ao serviço.
        $this->repository = $repository;
    }

    /**
     * Retorna o repositório associado ao serviço.
     * 
     * Este método fornece acesso ao repositório para realizar operações de dados.
     * 
     * @return Repository O repositório associado ao serviço.
     */
    public function repository()
    {
        // Retorna a instância do repositório.
        return $this->repository;
    }
}
