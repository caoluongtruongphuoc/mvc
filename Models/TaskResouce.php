<?php

namespace App\Models;

use App\Core\ResourceModel;

class TaskResource extends ResourceModel
{
    public function __construct() 
    {
        parent::_init("tasks", null, new Task());    
    }
}