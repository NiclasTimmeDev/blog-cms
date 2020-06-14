<?php

class Users extends Controller
{
    protected $userModel;

    private $login_data = array(
        "email" => "",
        "password" => "",
        "email_err" => "",
        "password_err" => ""
    );

    private $register_data = array(
        "username" => "",
        "email" => "",
        "password" => "",
        "password_confirm" => "",
        "username_err" => "",
        "email_err" => "",
        "password_err" => "",
        "password_confirm_err" => ""
    );

    public function __construct()
    {
        $this->userModel = $this->loadModel("User");
    }

    /*===========================
    LOGIN USER
    ===========================*/
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("/users/login", $this->login_data);
        } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user =  $this->login_user_in_db();
            if ($user) {
                $this->createUserSession($user);
                redirect("dashboard");
            } else {
                $this->login_data["email_err"] = "Login failed";
                $this->login_data["password_err"] = "Login failed";
                $this->loadView("/users/login", $this->login_data);
            }
        }
    }

    /*===========================
    REGISTER USER
    ===========================*/
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->loadView("/users/register", $this->register_data);
        } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->validate_register_input();
            if (
                $this->register_data["username_err"] == "" &&
                $this->register_data["password_err"] == "" &&
                $this->register_data["email_err"] == "" &&
                $this->register_data["password_confirm_err"] == ""
            ) {
                $new_user = $this->userModel->register($this->register_data["username"], $this->register_data["email"], $this->register_data["password"]);
                if ($new_user) {
                    $this->createUserSession($new_user);
                    flash("register_success", "You registered successfully");
                    redirect("/dahboard");
                } else {
                    $this->register_data["email_err"] = "This email address is aldready taken.";
                    $this->loadView("/users/register", $this->register_data);
                }
            } else {
                $this->loadView("/users/register", $this->register_data);
            }
        }
    }

    /*===========================
    CONDUCT LOGIN IN DATABASE
    ===========================*/
    private function login_user_in_db()
    {
        $this->validate_login_input();

        if ($this->login_data["email_err"] == "" && $this->login_data["password_err"] == "") {
            $user = $this->userModel->login($this->login_data["email"], $this->login_data["password"]);
            return $user;
        } else {
            return false;
        }
    }

    /*=====================
    VALIDATE LOGIN USER INPUT
    =====================*/
    private function validate_login_input()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $this->login_data["email"] = $_POST["email"];
        $this->login_data["password"] = $_POST["password"];

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
            $this->login_data["email_err"] = "Please enter an email address.";
        } else {
            $this->login_data["email_err"] = "";
        }
        $this->validation_helper("login", "password", "password_err", "Please enter a password");
    }

    /*=====================
    VALIDATE REGISTER USER INPUT
    =====================*/
    private function validate_register_input()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        foreach ($_POST as $key => $value) {
            $this->register_data[$key] = $value;
        }

        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
            $this->register_data["email_err"] = "Please enter a valid email address.";
        } else {
            $this->register_data["email_err"] = "";
        }
        $this->validation_helper("register", "username", "username_err", "Please enter a username.");
        $this->validation_helper("register", "password", "password_err", "Please enter a password");
        if ($this->register_data["password"] != $this->register_data["password_confirm"]) {
            $this->register_data["password_confirm_err"] = "Your two passwords must match!";
        }
    }


    private function validation_helper($method, $field, $error_field, $error_message)
    {
        if ($method == "register") {
            if (empty($this->register_data[$field])) {
                $this->register_data[$error_field] = $error_message;
            } else {
                $this->register_data[$error_field] = "";
            }
        }
        if ($method == "login") {
            if (empty($this->register_data[$field])) {
                $this->register_data[$error_field] = $error_message;
            } else {
                $this->register_data[$error_field] = "";
            }
        }
    }

    /*============================
    CREATE SESSION
    That way, user data will remain present when new page is loaded
    ============================*/
    private function createUserSession($user)
    {
        $_SESSION["user_id"] = $user->id;
        $_SESSION["user_username"] = $user->username;
        $_SESSION["user_mail"] = $user->email;
    }

    //unset all user-related session variables
    private function logout()
    {
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_username"]);
        unset($_SESSION["user_mail"]);
        session_destroy();
        redirect("");
    }
}