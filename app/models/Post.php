<?php

class Post extends Database
{
    /*====================
    CREATE NEW POST
    ====================*/
    public function create_post($title, $content, $url, $creator_id, $thumb_url)
    {
        if ($this->find_post_by_url($url)) {
            return false;
        } else {
            $this->stmt = $this->pdo->prepare("INSERT INTO posts (creator_id, title, content, url, thumb_url ) VALUES(:creator_id, :title, :content, :url, :thumb_url)");
            if ($this->stmt->execute([
                ":creator_id" => $creator_id,
                ":title" => $title,
                ":content" => $content,
                ":url" => $url,
                "thumb_url" => $thumb_url
            ])) {
                return $this->pdo->lastInsertId();
            } else {
                return false;
            }
        }
    }

    /*====================
    EDIT POST
    ====================*/
    public function edit_post($id, $title, $content, $post_thumb)
    {

        $this->stmt = $this->pdo->prepare("UPDATE posts SET title = :title, content = :content, thumb_url = :thumb_url WHERE id = :id");
        if ($this->stmt->execute([
            ":title" => $title,
            ":content" => $content,
            ":id" => $id,
            "thumb_url" => $post_thumb
        ])) {
            return true;
        } else {
            return false;
        }
    }

    /*====================
    DELETE ONE POST
    ====================*/
    public function delete_post($post_url)
    {
        $this->stmt = $this->pdo->prepare("DELETE FROM posts WHERE url = :url");
        if ($this->stmt->execute([
            ":url" => $post_url
        ])) {
            return true;
        } else {
            return false;
        }
    }

    /*====================
    FIND ALL POSTS
    ====================*/
    public function find_all_posts()
    {
        $this->stmt = $this->pdo->prepare("SELECT * FROM posts");
        $this->stmt->execute();
        return $this->stmt->fetchAll();
    }

    /*======================
    FIND ONE POST BY ITS URL
    ======================*/
    public function find_post_by_url($url)
    {
        $this->stmt = $this->pdo->prepare("SELECT * FROM posts where url = :url");
        $this->stmt->execute([
            ":url" => $url
        ]);
        return $this->stmt->fetch();
    }

    /*======================
    FIND ONE POST BY ITS ID
    ======================*/
    public function find_post_by_id($post_id)
    {
        $this->stmt = $this->pdo->prepare("SELECT * from posts where id = :id");
        $this->stmt->execute([
            ":id" => $post_id
        ]);
        return $this->stmt->fetch();
    }

    /*=========================
    FIND THE THREE LATEST POSTS
    =========================*/
    public function get_recent_posts()
    {
        $this->stmt = $this->pdo->prepare("SELECT * FROM posts ORDER BY ID DESC LIMIT 3");
        $this->stmt->execute();

        return $this->stmt->fetchAll();
    }
}