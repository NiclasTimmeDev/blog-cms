<?php
class Posts extends Controller
{

    private $post_data = [
        "title" => "",
        "content" => "",
        "url" => "",
        "thumb_url" => "",
        "title_err" => "",
        "content_err" => "",
        "thumbnail_err" => ""
    ];

    private $thumb_data = [
        "name" => "",
        "size" => "",
        "extension" => "",
        "newFileName" => "",
        "error" => "",
        "tmp_name" => "",
        "destination" => ""
    ];

    protected $post_model;

    public function __construct()
    {
        $this->post_model = $this->loadModel("Post");
    }

    /*==============================
    SHOW SINGLE POST
    ==============================*/
    public function single($post_url)
    {
        $post = $this->post_model->find_post_by_url($post_url);
        if (!$post) {
            $this->loadView("/pages/404");
        } else {
            $this->loadView("/posts/single", $post);
        }
    }

    /*======================
    CREATE POST
    ======================*/
    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("/posts/create", $this->post_data);
        } else if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->sanitize_post_inputs();
            if ($this->post_data["title_err"]  == "" && $this->post_data["content_err"]  == "" && $this->post_data["thumbnail_err"]  == "") {
                $this->generate_url();
                $this->upload_thumbnail();
                $new_post = $this->post_model->create_post($this->post_data["title"], $this->post_data["content"], $this->post_data["url"], $_SESSION["user_id"], $this->thumb_data["destination"]);

                if ($new_post && $new_post != "URL already taken") {
                    flash("create_post_success", "Contrats! You created a post.");
                    redirect("admins/dashboard");
                } elseif ($new_post = "URL already taken") {
                    flash("create_alert_failure", "The URL you are trying to create is already taken", "alert alert-danger");
                    $this->loadView("posts/create", $this->post_data);
                }
            } else {
                $this->loadView("posts/create", $this->post_data);
            }
        }
    }

    /*======================
    EDIT POST
    ======================*/
    public function edit($post_url)
    {
        $post = $this->post_model->find_post_by_url($post_url);
        if (!$post) {
            $this->loadView("pages/404");
        } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("posts/edit", $post);
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            //No need to filter content, as tinyMCE already does it
            $_POST["title"] = filter_var($_POST["title"], FILTER_SANITIZE_STRING);

            $post->title = $_POST["title"];
            $post->content = $_POST["content"];
            if ($this->post_model->edit_post($post)) {
                flash("edit_success", "Post updated successfully");
                redirect("posts/single/" . $post->url);
            } else {
                flash("edit_error", "Sorry, something went wrong. Please try again later", "alert alert-danger");
                $this->loadView("posts/edit", $post);
            }
        }
    }

    /*======================
    DELETE POST
    ======================*/
    public function delete($post_url)
    {
        if ($this->post_model->delete_post($post_url)) {
            flash("post_deleted_success", "Post deleted successfully");
            redirect("admins/dashboard");
        }
    }

    /*==============================
    SANITIZE USER INPUTS 
    ==============================*/
    private function sanitize_post_inputs()
    {
        //No need to filter content, as tinyMCE already does it
        $_POST["title"] = filter_var($_POST["title"], FILTER_SANITIZE_STRING);

        $this->post_data["title"] = $_POST["title"];
        $this->post_data["content"] = $_POST["content"];
        $this->sanitize_thumbnail_input();

        if (empty($this->post_data["title"])) {
            $this->post_data["title_err"] = "Please enter a title";
        } else {
            $this->post_data["title_err"] = "";
        }
        if (empty($this->post_data["content"])) {
            $this->post_data["content_err"] = "Please write some content";
        } else {
            $this->post_data["content_err"] = "";
        }
    }

    /*==============================
    SANITIZE THUMBNAIL INPUT
    ==============================*/
    private function sanitize_thumbnail_input()
    {

        $name = $_FILES["thumbnail"]["name"];
        $size = $_FILES["thumbnail"]["size"];
        $error = $_FILES["thumbnail"]["error"];
        $tmp_name = $_FILES["thumbnail"]["tmp_name"];
        $ext_unfiltered = explode(".", $name);
        $ext = strtolower(end($ext_unfiltered));
        $new_name = uniqid("", true) . "." . $ext;

        $allowedExtensions = array(
            "jpg", "jpeg", "png"
        );
        if (!in_array($ext, $allowedExtensions)) {
            $this->post_data["thumbnail_err"] = "Only jpg, JPEG and png are allowed";
        }
        if ($error !== 0) {
            $this->post_data["thumbnail_err"] = "There was an error while uploading.";
        }
        if ($size > 500000) {
            $this->post_data["thumbnail_err"] = "The image may not be larger than 5MB";
        }

        $this->thumb_data["name"] = $name;
        $this->thumb_data["size"] = $size;
        $this->thumb_data["error"] = $error;
        $this->thumb_data["tmp_name"] = $tmp_name;
        $this->thumb_data["extension"] = $ext;
        $this->thumb_data["newFileName"] = $new_name;
        echo $this->thumb_data["newFileName"];
    }

    /*==============================
    UPLOAD THUMBNAIL
    ==============================*/
    private function upload_thumbnail()
    {
        $destination = dirname(APPROOT) . "/public/uploads/" . $this->thumb_data["newFileName"];
        $this->thumb_data["destination"] = $this->thumb_data["newFileName"];
        echo $this->thumb_data["destination"];
        move_uploaded_file($this->thumb_data["tmp_name"], $destination);
    }

    /*========================
    GENERATE URL FROM POST TITLE
    ========================*/
    private function generate_url()
    {
        $this->post_data["url"] = strtolower($this->post_data["title"]);
        $this->post_data["url"] = preg_replace('/[^A-Za-z0-9. ]/', '', $this->post_data["url"]);
        $this->post_data["url"] = preg_replace('/  */', '-', $this->post_data["url"]);
        $this->post_data["url"] = filter_var($this->post_data["url"], FILTER_SANITIZE_URL);
    }
}