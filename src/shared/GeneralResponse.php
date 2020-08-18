<?php

class GeneralResponse {

    public function __construct(){}

    public function unprocessableEntityResponse()
    {
        header("HTTP/1.1 422 Not Found");
        return json_encode([
            "error" => "Invalid input"
        ]);
    }

    public function notFoundResponse($uri)
    {        
        header("HTTP/1.1 404 Not Found");
        return json_encode([
            "error" => $uri." not found"
        ]);
    }
}
?>