<?php
require_once("./src/controller/AccountCtrl.php");
require_once("./src/shared/GeneralResponse.php");

class AccountApi {

    private $requestMethod;
    private $uri;
    private $accountCtrl;
    private $generalResponse;


    public function __construct($requestMethod, $uri){
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;

        $this->accountCtrl = new AccountCtrl($uri);
        $this->generalResponse = new GeneralResponse();
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if (isset($_GET["Username"]) && isset($_GET["Password"])) {
                    $response = $this->accountCtrl->getAccountById($_GET["Username"],$_GET["Password"]);
                } else {
                    $response = $this->accountCtrl->getAllAccounts();
                };
                break;
            case 'POST':
                $response = $this->accountCtrl->createAccount();
                break;
            default:
                $response = $this->generalResponse->notFoundResponse("api");
                break;
        }
        if ($response) {
            return $response;
        }
    }
}
?>