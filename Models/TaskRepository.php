<?php

namespace App\Models;

use App\Models\TaskResource;

class TaskRepository
{
    public function save($model) 
    {
        $taskRs = new TaskResource();

        return $taskRs->save($model);
    }

    // getById
    public function get($id)
    {
        $taskRs = new TaskResource();

        return $taskRs->getById($id);
    }

    public function delete($model)
    {
        $taskRs = new TaskResource();
        return $taskRs->delete($model);
    }

    // theo biểu đồ là getAll($model)
    public function getAll()
    {
        $taskRs = new TaskResource();
        return $taskRs->getAll();
    }
}