<?php

class Admins extends Controller
{
    protected $admin_model;
    protected $post_model;

    protected $data = [
        "recent_posts" => ""
    ];

    public function __construct()
    {
        $this->admin_model = $this->loadModel("Admin");
        $this->post_model = $this->loadModel("Post");
    }

    public function dashboard()
    {
        $latest_posts  = $this->post_model->get_recent_posts();
        $this->data["recent_posts"] = $latest_posts;
        $this->loadView("/admins/dashboard", $this->data);
    }

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
}