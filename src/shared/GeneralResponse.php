<?php

class GeneralResponse {

    public function __construct(){}

    public function unprocessableEntityResponse()
    {
        header("HTTP/1.1 422 Not Found");
        $response["status_code_header"] = "HTTP/1.1 422 Unprocessable Entity";
        $response["body"] = json_encode([
            "error" => "Invalid input"
        ]);
        return $response;
    }

    public function notFoundResponse($uri)
    {        
        header("HTTP/1.1 404 Not Found");
        $response["status_code_header"] = "HTTP/1.1 404 Not Found";
        $response["body"] = json_encode([
            "error" => $uri[2]." not found"
        ]);
        return $response;
    }
}
?>