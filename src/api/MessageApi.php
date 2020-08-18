<?php
require_once("./src/controller/MessageCtrl.php");
require_once("./src/shared/GeneralResponse.php");

class MessageApi {

    private $requestMethod;
    private $uri;
    private $messageCtrl;
    private $generalResponse;


    public function __construct($requestMethod, $uri){
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;

        $this->messageCtrl = new MessageCtrl($uri);
        $this->generalResponse = new GeneralResponse();
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->uri[3]) {
                    $response = $this->messageCtrl->getMessage($this->uri[3]);
                } else {
                    $response = $this->messageCtrl->getAllMessages();
                };
                break;
            case 'POST':
                $response = $this->messageCtrl->createMessageFromRequest();
                break;
            default:
                $response = $this->generalResponse->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response) {
            return $response;
        }
    }
}
?>