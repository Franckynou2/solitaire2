<?php
/*
* src/Core/Response/Response.php
*/


abstract class Response {
    /**
    * @var string $httpHeaders
    */
    protected $httpHeaders;

    /**
    * @var string $content
    */
    protected $content;

    abstract public function send(){
    }

    protected function addHeaders(string $header):string{
        $this->httpHeaders=$header;
        return $this->httpHeaders;
    }

    protected function sendHeaders(string $header):string{
        foreach($this->httpheaders as $httpHeader){
            header($httpHeader);
        }
    }

    public function setContent(string $content){
        $this->content=$content;
    }
    

}
