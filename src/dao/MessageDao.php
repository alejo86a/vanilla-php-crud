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
        if (file_exists($this->file_name)) { 
            $data = file_get_contents($this->file_name);
            $result = json_decode($data, true);
            $r = null;
            foreach($result["Messages"] as $m){
                if($m["id"]==$id){
                    $r=$m;
                }
            }
            return $r;
        }
    }

    public function insert(Array $input) {

    }

    public function findByText($text) {
        if (file_exists($this->file_name)) { 
            $data = file_get_contents($this->file_name);
            $result = json_decode($data, true);
            $r = [];
            foreach($result["Messages"] as $m){
                $pos = strrpos($m["Comment"], $text);
                if(is_numeric($pos)){
                    array_push($r,$m);
                }
            }
            return $r;
        }
    }

    public function findByDate($date) {
        if (file_exists($this->file_name)) { 
            $data = file_get_contents($this->file_name);
            $result = json_decode($data, true);
            $r = [];
            foreach($result["Messages"] as $m){
                if($m["Created_at"]>=$date){
                    array_push($r,$m);
                }
            }
            return $r;
        }
    }
}
?>