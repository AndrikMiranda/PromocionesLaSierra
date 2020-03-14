<?php


class ErrorResponse {

    private $message;
    private $responseCode;
    private $hasError;

    /*
    -- Message -> Mensaje de respuesta (STRING)
    -- responseCode -> Http response code (INT)
    -- hasError -> True (Es error) , False(No es error). Los navegadores se apendejan, mejor nosotros mismos regresamos un booleano para asegurarnos.
    */

    function __construct($responseCode,  $message, $hasError ) {
        $this->responseCode = $responseCode; 
        $this->message = $message; 
        $this->hasError = $hasError;
    }
      
    function setMessage($message) { 
        $this->message = $message;
    }

    function setResponseCode($responseCode) { 
        $this->responseCode = $responseCode;
    }

    function setHasError($hasError) { 
        $this->hasError = $hasError;
    }

    function getMessage(){
        return $this->message;
    }

    function getResponseCodee(){
        return $this->responseCode;
    }

    function getHasError(){
        return $this->hasError;
    }

}
