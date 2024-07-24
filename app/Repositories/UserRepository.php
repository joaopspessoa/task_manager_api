<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Repositório de usuários responsável por gerenciar operações de banco de dados relacionadas ao modelo User.
 */
class UserRepository extends Repository
{
    /**
     * Construtor da classe UserRepository.
     *
     * @param User $model Instância do modelo User.
     */
    public function __construct(User $model)
    {
        // Chama o construtor da classe pai e injeta o modelo User.
        parent::__construct($model);
    }
}
