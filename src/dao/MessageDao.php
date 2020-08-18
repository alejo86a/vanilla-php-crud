<?php

class MessageDao {
    private $file_name = "./db.json";

    public function __construct() {}

    public function findAll() {
        if (file_exists($this->file_name)) { 
            $data = file_get_contents($this->file_name);
            $result = json_decode($data, true);
            return $result["Messages"];
        }
    }

    public function find($id) {

    }

    public function insert(Array $input) {

    }

    public function findByText($text) {

    }

    public function findByDate($start,$end) {

    }
}
?>