<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends Repository
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }
}
