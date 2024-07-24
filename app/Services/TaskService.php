<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Serviço específico para a manipulação de tarefas.
 * 
 * Esta classe fornece métodos para criar, recuperar, atualizar e excluir tarefas,
 * estendendo as funcionalidades gerais fornecidas pela classe base Service.
 */
class TaskService extends Service
{
    /**
     * Construtor da classe.
     * 
     * Inicializa o serviço com um repositório específico de tarefas.
     * 
     * @param TaskRepository $repository O repositório de tarefas que será utilizado pelo serviço.
     */
    public function __construct(TaskRepository $repository)
    {
        // Chama o construtor da classe base Service e injeta o repositório de tarefas.
        parent::__construct($repository);
    }

    /**
     * Cria uma nova tarefa.
     * 
     * Recebe os dados da requisição, define o status padrão como 'pending' e associa a tarefa ao usuário autenticado.
     * 
     * @param Request $request Dados da requisição que contêm as informações da tarefa.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com a tarefa criada e o status HTTP 201.
     */
    public function store(Request $request)
    {
        // Obtém o usuário autenticado.
        $auth_user = Auth::user();

        // Obtém todos os dados da requisição.
        $data = $request->all();
        $data['status'] = 'pending'; // Define o status padrão da tarefa.
        $data['user_id'] = $auth_user->id; // Associa a tarefa ao usuário autenticado.

        // Cria a tarefa no repositório.
        $task = $this->repository->create($data);

        // Retorna a tarefa criada com status HTTP 201.
        return response()->json(['task' => $task], 201);
    }

    /**
     * Recupera as tarefas do usuário autenticado.
     * 
     * Aplica filtros baseados no status da tarefa, se fornecido.
     * 
     * @param Request $request Dados da requisição que podem conter filtros de status.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com a lista de tarefas ou mensagem de erro e status HTTP 200 ou 400.
     */
    public function get(Request $request)
    {
        // Obtém o usuário autenticado.
        $auth_user = Auth::user();

        // Define os filtros para recuperar as tarefas do usuário.
        $filters = [
            'user_id' => $auth_user->id,
        ];

        // Adiciona filtro de status, se fornecido.
        if (isset($request->status) && $request->status) {
            $filters['status'] = $request->status;
        }

        // Recupera tarefas filtradas do repositório.
        $tasks = $this->repository->get($filters, 'created_at', 'asc');

        // Retorna mensagem de erro se nenhuma tarefa for encontrada.
        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'Tasks not found.'], 400);
        }

        // Retorna a lista de tarefas com status HTTP 200.
        return response()->json(['tasks' => $tasks], 200);
    }

    /**
     * Recupera uma tarefa específica pelo ID.
     * 
     * @param string $id ID da tarefa a ser recuperada.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com a tarefa encontrada ou mensagem de erro e status HTTP 200 ou 404.
     */
    public function show(string $id)
    {
        // Recupera a tarefa pelo ID.
        $task = $this->repository->find($id);

        // Retorna mensagem de erro se a tarefa não for encontrada.
        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        // Retorna a tarefa encontrada com status HTTP 200.
        return response()->json(['task' => $task], 200);
    }

    /**
     * Atualiza uma tarefa existente.
     * 
     * Recebe os dados da requisição e o ID da tarefa a ser atualizada. 
     * Se a tarefa não for encontrada, retorna mensagem de erro.
     * 
     * @param Request $request Dados da requisição com as informações atualizadas da tarefa.
     * @param string $id ID da tarefa a ser atualizada.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com mensagem de sucesso ou erro e status HTTP 200 ou 404.
     */
    public function update(Request $request, string $id)
    {
        // Recupera a tarefa pelo ID.
        $task = $this->repository->find($id);

        // Retorna mensagem de erro se a tarefa não for encontrada.
        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        // Obtém todos os dados da requisição.
        $data = $request->all();

        // Atualiza a tarefa no repositório.
        $this->repository->updateById($id, $data);

        // Retorna mensagem de sucesso com status HTTP 200.
        return response()->json(['message' => 'Task updated successfully.'], 200);
    }

    /**
     * Exclui uma tarefa existente pelo ID.
     * 
     * Se a tarefa não for encontrada, retorna mensagem de erro.
     * 
     * @param string $id ID da tarefa a ser excluída.
     * @return \Illuminate\Http\JsonResponse Resposta JSON com mensagem de sucesso ou erro e status HTTP 200 ou 404.
     */
    public function delete(string $id)
    {
        // Recupera a tarefa pelo ID.
        $task = $this->repository->find($id);

        // Retorna mensagem de erro se a tarefa não for encontrada.
        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        // Exclui a tarefa do repositório.
        $this->repository->deleteById($id);

        // Retorna mensagem de sucesso com status HTTP 200.
        return response()->json(['message' => 'Task deleted successfully.'], 200);
    }
}
