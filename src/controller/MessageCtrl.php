<?php
require_once("./src/shared/GeneralResponse.php");
require_once("./src/dao/MessageDao.php");

class MessageCtrl {
    private $uri;

    private $messageDao;
    private $generalResponse;

    public function __construct($uri){
        $this->uri = $uri;

        $this->generalResponse = new GeneralResponse();
        $this->messageDao = new MessageDao();
    }

    public function getAllMessages(){
        $result = $this->messageDao->findAll();
        header("status_code_header: HTTP/1.1 200 OK");
        return $result;
    }

    public function getMessageById($id){
        $result = $this->messageDao->find($id);
        if (! $result) {
            return $this->generalResponse->notFoundResponse("message not found");
        }        
        header("status_code_header: HTTP/1.1 200 OK");
        return $result;
    }

    public function getMessageByText($text){
        $result = $this->messageDao->findByText($text);
        if (! $result) {
            return $this->generalResponse->notFoundResponse("any message");
        }        
        header("status_code_header: HTTP/1.1 200 OK");
        return $result;
    }

    public function getMessageByDate($date){
        $result = $this->messageDao->findByDate($date);
        if (! $result) {
            return $this->generalResponse->notFoundResponse("message");
        }        
        header("status_code_header: HTTP/1.1 200 OK");
        return $result;
    }

    public function createMessageFromRequest(){
        $input = (array) json_decode(file_get_contents("php://input"), TRUE);
        if (! $this->validateMessage($input)) {
            return $this->generalResponse->unprocessableEntityResponse();
        }
        $result = $this->messageDao->insert($input);
        header("status_code_header: HTTP/1.1 201 Created");
        return $result;
    }

    private function validateMessage($input)
    {        
        if (! isset($input["Username"])) {
            return false;
        }
        if (! isset($input["Comment"])) {
            return false;
        }
        if (! isset($input["Created_at"])) {
            return false;
        }
        return true;
    }
}
?>