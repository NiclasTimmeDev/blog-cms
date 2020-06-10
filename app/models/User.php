<?php
class User extends Database
{
    /*================================
    LOGIN
    ================================*/
    public function login($email, $password)
    {

        $user = $this->find_user_by_mail($email);
        if (!$user) {
            return false;
        } else if (!password_verify($password, $user->password)) {
            return false;
        } else {
            return $user;
        }
    }


    /*================================
    REGISTER
    ================================*/
    public function register($username, $email, $password)
    {
        if ($this->find_user_by_mail($email)) {
            return false;
        } else {
            $pw = password_hash($password, PASSWORD_DEFAULT);
            $this->stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES(:username, :email, :password)");

            if ($this->stmt->execute(array(
                ":username" => $username,
                ":email" => $email,
                ":password" => $pw
            ))) {
                return $this->pdo->lastInsertId();
            } else {
                return false;
            }
        }
    }

    /*================================
    FIND USER BY MAIL
    ================================*/
    private function find_user_by_mail($email)
    {
        $this->stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $this->stmt->execute(array(
            ":email" => $email
        ));

        return $this->stmt->fetch();
    }
}