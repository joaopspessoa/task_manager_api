<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

/**
 * Controller responsável por gerenciar operações relacionadas a tarefas.
 */
class TaskController extends Controller
{
    /**
     * Construtor da classe TaskController.
     *
     * @param TaskService $service Serviço de gerenciamento de tarefas.
     */
    public function __construct(TaskService $service)
    {
        // Chama o construtor da classe pai e injeta o serviço de gerenciamento de tarefas.
        parent::__construct($service);
    }

    /**
     * Cria uma nova tarefa.
     *
     * @param StoreTaskRequest $request Requisição validada para criação de uma nova tarefa.
     * @return \Illuminate\Http\Response Resposta HTTP com o resultado da criação da tarefa.
     */
    public function store(StoreTaskRequest $request)
    {
        // Chama o método de armazenamento do serviço de tarefas.
        return $this->service->store($request);
    }

    /**
     * Obtém uma lista de tarefas.
     *
     * @param Request $request Requisição HTTP para obtenção de tarefas, com possíveis filtros.
     * @return \Illuminate\Http\Response Resposta HTTP com a lista de tarefas.
     */
    public function get(Request $request)
    {
        // Chama o método de obtenção de tarefas do serviço de tarefas.
        return $this->service->get($request);
    }

    /**
     * Exibe uma tarefa específica.
     *
     * @param string $id O ID da tarefa a ser exibida.
     * @return \Illuminate\Http\Response Resposta HTTP com os detalhes da tarefa.
     */
    public function show(string $id)
    {
        // Chama o método de exibição de uma tarefa do serviço de tarefas.
        return $this->service->show($id);
    }

    /**
     * Atualiza uma tarefa existente.
     *
     * @param UpdateTaskRequest $request Requisição validada para atualização de uma tarefa.
     * @param string $id O ID da tarefa a ser atualizada.
     * @return \Illuminate\Http\Response Resposta HTTP confirmando a atualização da tarefa.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        // Chama o método de atualização do serviço de tarefas.
        return $this->service->update($request, $id);
    }

    /**
     * Exclui uma tarefa existente.
     *
     * @param string $id O ID da tarefa a ser excluída.
     * @return \Illuminate\Http\Response Resposta HTTP confirmando a exclusão da tarefa.
     */
    public function delete(string $id)
    {
        // Chama o método de exclusão do serviço de tarefas.
        return $this->service->delete($id);
    }
}
