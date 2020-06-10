<?php

class Pages extends Controller
{
    public function index()
    {

        $this->loadView("/pages/index");
    }

    public function home()
    {
        echo "Home in Pages";
    }
}