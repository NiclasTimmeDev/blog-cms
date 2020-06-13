<?php
class Navbar extends Controller
{
    protected $admin_model;
    protected $navbar_items;
    public function __construct()
    {
        $this->admin_model = $this->loadModel("Admin");
        $this->navbar_items = $this->admin_model->get_navbar_items();
        $this->loadView("includes/navbar", $this->navbar_items);
    }
}