<?php

namespace App\Core;

class Model
{
    protected function getProperties() 
    {
        return get_object_vars($this);
    }
}
