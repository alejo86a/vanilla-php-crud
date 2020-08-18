<?php

class AccountDao {
    private $file_name = "./db.json";

    public function __construct() {}

    public function findAll() {
        if (file_exists($this->file_name)) { 
            $data = file_get_contents($this->file_name);
            $result = json_decode($data, true);
            return $result["Accounts"];
        }
    }

    public function find($username, $password) {
        if (file_exists($this->file_name)) { 
            $data = file_get_contents($this->file_name);
            $result = json_decode($data, true);
            $r = null;
            foreach($result["Accounts"] as $a){
                if($a["Username"]==$username && $a["Password"]==$password){
                    $r=$a;
                }
            }
            return $r;
        }
    }

    public function insert(Array $input) {
        if (file_exists($this->file_name)) { 
            $data = file_get_contents($this->file_name);
            $current_data = json_decode($data, true);
            $maxId = 0;
            foreach($current_data["Accounts"] as $a){
                if($maxId<$a["id"]){
                    $maxId=$a["id"];
                }
            }
            $input["id"]=$maxId+1;
            array_push($current_data["Accounts"],$input);
            file_put_contents($this->file_name, json_encode($current_data));
            return $input;
        }
    }
}
?>