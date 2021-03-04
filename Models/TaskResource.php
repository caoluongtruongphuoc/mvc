<?php

namespace App\Models;

use App\Core\ResourceModel;
use App\Models\Task;

class TaskResource extends ResourceModel
{
    public function __construct() 
    {
        $this->_init("tasks", null, new Task());    
    }
}