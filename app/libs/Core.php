<?php
class Core
{
    private $currentController = "Pages";
    private $currentMethod = "index";
    private $params = [];

    public function __construct()
    {
        $url = $this->getURL();

        if (isset($url[0])) {
            $this->set_current_controller($url[0]);
            unset($url[0]);
        }

        require_once(APPROOT . "/controllers/" . $this->currentController . ".php");

        $this->currentController = new $this->currentController();

        if (isset($url[1])) {
            $this->set_current_method($url[1]);
            unset($url[1]);
        }

        $url ? $this->params = $url : [];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    private function set_current_controller($controller)
    {
        if (file_exists("../app/controllers/" . ucwords($controller . ".php"))) {
            $this->currentController = ucwords($controller);
        }
    }

    private function set_current_method($method)
    {
        if (method_exists($this->currentController, $method)) {
            $this->currentMethod = $method;
        }
    }

    private function getURL()
    {
        if (isset($_GET["url"])) {
            $url = rtrim($_GET["url"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);
            return $url;
        }
    }
}