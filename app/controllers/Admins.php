<?php

class Admins extends Controller
{
    protected $admin_model;
    protected $post_model;

    protected $navbar_items_data = array();

    protected $new_navbar_item_data = array(
        "name" => "",
        "link" => "",
        "name_err" => "",
        "link_err" => ""
    );

    protected $data = [
        "recent_posts" => ""
    ];

    protected $navbar_oder_data = array();

    public function __construct()
    {
        $this->admin_model = $this->loadModel("Admin");
        $this->post_model = $this->loadModel("Post");
    }

    /*===============================
    SHOW DASHBOARD
    ===============================*/
    public function dashboard()
    {
        $latest_posts  = $this->post_model->get_recent_posts();
        $this->data["recent_posts"] = $latest_posts;
        $this->loadView("/admins/dashboard", $this->data);
    }

    /*===============================
    SHOW POSTS
    ===============================*/
    public function posts()
    {
        $posts = $this->post_model->find_all_posts();

        if (!$posts) {
            flash("find_all_posts_error", "Sorry, no posts were found.");
            redirect("admins/dashboard");
        } elseif ($posts) {
            $this->loadView("admins/posts/all", $posts);
        }
    }

    /*===============================
    EDIT POST
    ===============================*/
    public function edit($component)
    {
        call_user_func_array(array("Admins", $component), array());
    }

    /*===============================
    NAVBAR
    ===============================*/
    private function navbar()
    {
        $this->navbar_items_data = $this->admin_model->get_navbar_items();
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("/admins/edit/navbar", $this->navbar_items_data);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->set_navbar_items($_POST);
        }
    }

    /*===============================
    SET NAVBAR ITEMS
    ===============================*/
    private function set_navbar_items($post)
    {
        foreach ($this->navbar_items_data as $data_point) {
            $sanitized_name = str_replace(array(".", " "), "_", $data_point->name);
            if (array_key_exists($sanitized_name, $post)) {
                $data_point->selected = 1;
            } else {
                $data_point->selected = 0;
            }
        }

        if ($this->admin_model->set_navbar_items($this->navbar_items_data)) {

            flash("updated_navbar_success", "Navbar edited successfully");
            redirect("admins/dashboard");
        } else {
            flash("update_navbar_error", "Sorry, something went wrong. Try again later.", "alert alert-danger");
            redirect("admins/edit/navbar", $this->navbar_items_data);
        }
    }

    /*===============================
    NEW NAVBAR ITEM
    ===============================*/
    private function navbar_item()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = filter_var($_POST["new_item_name"], FILTER_SANITIZE_STRING);
            $this->new_navbar_item_data["name"] = $name;

            if (empty($this->new_navbar_item_data["name"])) {
                $this->new_navbar_item_data["name_err"] = "Please enter a name for your link";
            }
            $this->sanitize_new_navbar_items($_POST);
            if (empty($this->new_navbar_item_data["name_err"]) && empty($this->new_navbar_item_data["link_err"])) {
                if ($this->admin_model->create_new_nav_item($this->new_navbar_item_data["name"], $this->new_navbar_item_data["link"])) {
                    flash("create_link_success", "Link created successfully");
                    redirect("admins/edit/navbar");
                } else {
                    flash("create_link_error", "Sorry, something went wrong", "alert alert-danger");
                    redirect("admins/edit/navbar");
                }
            } else {
                flash("create_link_error", "Sorry, something went wrong", "alert alert-danger");
                redirect("admins/edit/navbar");
            }
        }
    }

    /*===============================
    SANITIZE NEW NAVBAR ITEMS
    ===============================*/
    private function sanitize_new_navbar_items($post)
    {
        if (!empty($post["new_item_internal_link"]) && !empty($post["new_item_external_link"])) {
            $this->new_navbar_item_data["link_err"] = "You cannot enter an internal and external link at the same time.";
        } elseif (!empty($post["new_item_internal_link"])) {
            $link = filter_var($post["new_item_internal_link"], FILTER_SANITIZE_URL);
            $this->new_navbar_item_data["link"] = URLROOT . "/" . $link;
        } elseif (!empty($post["new_item_external_link"])) {
            $link = filter_var($post["new_item_external_link"], FILTER_SANITIZE_URL);
            $this->new_navbar_item_data["link"] = $link;
        }
    }

    /*===============================
    EDIT NAVBAR ORDER
    ===============================*/
    public function navbar_order()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->navbar_items_data = $this->admin_model->get_navbar_items();
            $this->set_navbar_order($_POST);
            if ($this->admin_model->set_navbar_items($this->navbar_items_data)) {
                flash("navbar_order_success", "The order of your navbar items was edited successfully");
                redirect("admins/edit/navbar");
            } else {
                flash("navbar_order_err", "Sorry, something went wrong.Please try again later", "alert alert-danger");
                redirect("admins/edit/navbar");
            }
        }
    }

    /*===============================
    SANITIZE NAVBAR ORDER INPUTS
    ===============================*/
    private function set_navbar_order($post)
    {
        $arr = array_keys($post);
        foreach ($this->navbar_items_data as $data_point) {
            $sanitized_name = str_replace(array(".", " "), "_", $data_point->name);
            for ($i = 0; $i < count($post); $i++) {
                if ($sanitized_name == $arr[$i]) {
                    $data_point->order_number = $i + 1;
                }
            }
        }
    }
}