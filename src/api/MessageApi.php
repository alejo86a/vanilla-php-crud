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

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if (isset($_GET["search"])){
                    $response = $this->messageCtrl->getMessageByText($_GET["search"]);
                } else if(isset($_GET["date"])){
                    $response = $this->messageCtrl->getMessageByDate($_GET["date"]);
                } else if ($this->uri[3]) {
                    $response = $this->messageCtrl->getMessageById($this->uri[3]);
                } else {
                    $response = $this->messageCtrl->getAllMessages();
                };
                break;
            case 'POST':
                $response = $this->messageCtrl->createMessageFromRequest();
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