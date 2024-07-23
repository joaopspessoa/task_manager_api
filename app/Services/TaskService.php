<?php

namespace App\Services;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskService extends Service
{
    public function __construct(TaskRepository $repository)
    {
        parent::__construct($repository);
    }

    public function store(Request $request)
    {
        $auth_user = Auth::user();

        $data = $request->all();
        $data['status'] = 'pending';
        $data['user_id'] = $auth_user->id;

        $task = $this->repository->create($data);

        return response()->json(['task' => $task], 201);
    }

    public function get(Request $request)
    {
        $auth_user = Auth::user();

        $filters = [
            'user_id' => $auth_user->id,
        ];

        if (isset($request->status) && $request->status) {
            $filters['status'] = $request->status;
        }

        $tasks = $this->repository->get($filters, 'created_at', 'asc');

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'Tasks not found.'], 400);
        }

        return response()->json(['tasks' => $tasks], 200);
    }

    public function show(string $id)
    {
        $task = $this->repository->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        return response()->json(['task' => $task], 200);
    }

    public function update(Request $request, string $id)
    {
        $task = $this->repository->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $data = $request->all();

        $this->repository->updateById($id, $data);

        return response()->json(['message' => 'Task updated successfully.'], 200);
    }

    public function delete(string $id)
    {
        $task = $this->repository->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        $this->repository->deleteById($id);

        return response()->json(['message' => 'Task deleted successfully.'], 200);
    }
}
