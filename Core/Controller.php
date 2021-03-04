<?php

namespace App\Core;

class Controller
{
    public $vars = [];
    public $layout = "default";

    protected function set($data)
    {
        $this->vars = array_merge($this->vars, $data);
    }

    protected function render($filename)
    {
        extract($this->vars);
        ob_start();

        //ví dụ App\Controllers\TaskController
        $path = str_replace(["App\\Controllers", "Controller"],"",get_class($this)); 
        require("../Views/" . $path . "/" . $filename . '.php');
        $content_for_layout = ob_get_clean();

        if ($this->layout == false) {
            $content_for_layout;
        } else {
            require("../Views/Layouts/" . $this->layout . '.php');
        }
    }

    protected function secure_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

    protected function secure_form($form)
    {
        foreach ($form as $key => $value)
        {
            $form[$key] = $this->secure_input($value);
        }
    }
}
