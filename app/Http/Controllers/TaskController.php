<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(TaskService $service)
    {
        parent::__construct($service);
    }

    public function store(StoreTaskRequest $request)
    {
        return $this->service->store($request);
    }

    public function get(Request $request)
    {
        return $this->service->get($request);
    }

    public function show(string $id)
    {
        return $this->service->show($id);
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        return $this->service->update($request, $id);
    }

    public function delete(string $id)
    {
        return $this->service->delete($id);
    }
}
