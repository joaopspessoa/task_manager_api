<?php

namespace App\Repositories;

use App\Models\Task;

/**
 * Repositório específico para a entidade Task.
 * 
 * Esta classe fornece métodos específicos para manipulação de tarefas, 
 * estendendo as funcionalidades gerais do repositório base.
 */
class TaskRepository extends Repository
{
    /**
     * Construtor da classe.
     * 
     * Inicializa o repositório com um modelo específico de Task.
     * 
     * @param Task $model O modelo de tarefa que será utilizado pelo repositório.
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
}
