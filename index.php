<?php
require_once("src/shared/GeneralResponse.php");
require_once("src/api/MessageApi.php");
require_once("src/api/AccountApi.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uri = explode("/", $uri);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$generalResponse = new GeneralResponse();

// all of our endpoints start with /api
// everything else results in a 404 Not Found
if ($uri[1] !== "api") {
    header("HTTP/1.1 404 Not Found");
    exit();
}

if($uri[2] !== null){
    switch($uri[2]){
        case "message":
            $api = new MessageApi($requestMethod,$uri);
            $response = $api->processRequest();
            break;
        case "account":
            $api = new AccountApi($requestMethod,$uri);
            $response = $api->processRequest();
            break;
        default:
        $response = $generalResponse->notFoundResponse($uri[2]);
    }
} else {
    $response = $generalResponse->notFoundResponse($uri[2]);
}

echo json_encode($response);
?>