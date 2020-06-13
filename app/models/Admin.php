<?php

class Admin extends Database
{
    public function get_navbar_items()
    {
        $this->stmt = $this->pdo->prepare("SELECT * FROM navbar ORDER BY order_number ASC");
        $this->stmt->execute();
        return $this->stmt->fetchAll();
    }

    public function set_navbar_items($items)
    {
        $existing_items = $this->get_navbar_items();
        $no_error = true;


        foreach ($items as $item) {
            $this->stmt = $this->pdo->prepare("UPDATE navbar set selected = :selected, order_number = :order_number WHERE name = :name");
            if ($this->stmt->execute([
                ":name" => $item->name,
                ":selected" => $item->selected,
                ":order_number" => $item->order_number
            ])) {
                continue;
            } else {
                $no_error = false;
            }
        }

        return $no_error;
    }

    public function create_new_nav_item($name, $link)
    {
        //neccessary to set order number to the last one:
        $existing_items = $this->get_navbar_items();
        $number_of_entries = count($existing_items);

        $this->stmt = $this->pdo->prepare("INSERT INTO navbar (name, link, order_number, selected) values (:name, :link, :order_number, :selected)");

        if ($this->stmt->execute([
            ":name" => $name,
            "link" => $link,
            "order_number" => $number_of_entries + 1,
            "selected" => 0
        ])) {
            return $this->pdo->lastInsertId();
        }
    }
}