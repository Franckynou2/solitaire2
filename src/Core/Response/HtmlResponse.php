<?php
/**
* src/Core/Response/HtmlResponse.php
*/
require_once(__DIR__ . '/Response.php');



class HtmlResponse extends Response {
    
    public function _construct() {
        $this->addHeader('Content-Type: text/html;Charset=utf-8');
    }
    
    public function send() {
        echo ‘Je suis un contenu HTML’ ;
        $this->sendHeaders();
    }
    
    public function setContent(){ 
    }
}