<?php
class Controller
{
    public function loadModel($model)
    {
        if (file_exists(APPROOT . "/models/" . $model . ".php")) {
            require_once(APPROOT . "/models/" . $model . ".php");
            return new $model();
        }
    }
    public function loadView($view, $data = [])
    {
        if (file_exists(APPROOT . "/views/" . $view . ".php")) {
            require_once(APPROOT . "/views/" . $view . ".php");
        }
    }
}