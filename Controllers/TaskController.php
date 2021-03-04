<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Task;
use App\Models\TaskRepository;

class TaskController extends Controller
{
    public function index()
    {
        $taskRepo = new TaskRepository();
        $data['tasks'] = $taskRepo->getAll();
        $this->set($data);
        $this->render("index");
    }

    public function create()
    {
        if (isset($_POST["title"])) {
            $task = new Task();
            $task->setTitle($_POST["title"]);
            $task->setDescription($_POST["description"]);
            $taskRepo = new TaskRepository();

            if ($taskRepo->save($task)) {
                header("Location: " . WEBROOT . "task/index");
            }
        }

        $this->render("create");
    }

    public function edit($id)
    {
        $taskRepo = new TaskRepository();
        $data["task"] = $taskRepo->get($id);;

        if (isset($_POST["title"])) {
            $task = new Task();
            $task->setId($id);
            $task->setTitle($_POST["title"]);
            $task->setDescription($_POST["description"]);

            if ($taskRepo->save($task)) {
                header("Location: " . WEBROOT . "task/index");
            }
        }
        
        $this->set($data);
        $this->render("edit");
    }

    public function delete($id)
    {
        $taskRepo = new TaskRepository();
        $task = $taskRepo->get($id);

        if ($taskRepo->delete($task)) {
            header("Location: " . WEBROOT . "task/index");
        }
    }
}
