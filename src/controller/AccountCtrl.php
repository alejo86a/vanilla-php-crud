<?php
require_once("./src/shared/GeneralResponse.php");
require_once("./src/dao/AccountDao.php");

class AccountCtrl {
    private $uri;

    private $accountDao;
    private $generalResponse;

    public function __construct($uri){
        $this->uri = $uri;

        $this->generalResponse = new GeneralResponse();
        $this->accountDao = new AccountDao();
    }

    public function getAllAccounts(){
        $result = $this->accountDao->findAll();
        header("status_code_header: HTTP/1.1 200 OK");
        return $result;
    }

    public function getAccountById($username,$password){
        $result = $this->accountDao->find($username,$password);
        if (! $result) {
            return $this->generalResponse->notFoundResponse("account not found");
        }        
        header("status_code_header: HTTP/1.1 200 OK");
        return $result;
    }

    public function createAccount(){
        $input = (array) json_decode(file_get_contents("php://input"), TRUE);
        if (! $this->validateAccount($input)) {
            return $this->generalResponse->unprocessableEntityResponse();
        }
        $result = $this->accountDao->insert($input);
        header("status_code_header: HTTP/1.1 201 Created");
        return $result;
    }

    private function validateAccount($input)
    {
        // preg_match('/(foo)(bar)(baz)/', $input["Username"], $validUsername, PREG_OFFSET_CAPTURE);
        // // preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $input["Email"], $validEmail, PREG_OFFSET_CAPTURE);
        // preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $input["Email"], $validEmail, PREG_OFFSET_CAPTURE);
        // preg_match('/(foo)(bar)(baz)/', $input["Phone_number"], $validPhone_number, PREG_OFFSET_CAPTURE);
        // preg_match('/(foo)(bar)(baz)/', $input["Password"], $validUserPassword, PREG_OFFSET_CAPTURE);
        // echo $validEmail;
        if (! isset($input["Username"])) {
            return false;
        }
        if (! isset($input["Email"]) || preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/', $input["Email"])) {
            return false;
        }
        if (! isset($input["Phone_number"]) && $validPhone_number>0) {
            return false;
        }
        if (! isset($input["Password"]) && $validUserPassword>0) {
            return false;
        }
        return true;
    }
}
?>