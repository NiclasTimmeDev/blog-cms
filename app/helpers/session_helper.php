<?php
session_start();

//flash messages
function flash($name = "", $message = "", $class = "alert alert-success")
{
    /*
    If name and message are given, check that no other session like that exists
    If another session like this exists, exit
    If no other session exists, create a new one with the name $name, message $message and class $name_class
    If only the name is provided, create div with alert and then unset the session
    */
    if (!empty($name)) {
        if (!empty($name) && !empty($message)) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name . "_class"])) {
                unset($_SESSION[$name . "_class"]);
            }
            $_SESSION[$name] = $message;
            $_SESSION[$name . "_class"] = $class;
        } elseif (empty($message) && !empty($name) && !empty($_SESSION[$name])) {
            echo '<div class="' . $_SESSION[$name . "_class"] . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . "_class"]);
            unset($_SESSION[$message]);
        }
    }
}