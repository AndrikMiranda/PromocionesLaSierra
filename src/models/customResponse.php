<?php


class CustomResponse {

    public $countTotal;
    public $responseCode;
    public $page;
    public $mObject;
    public $filterParams;
    
    /*
    -- $countTotal (INT)
    -- $responseCode (INT)
    -- $page (INT)
    -- $mObject (Objeto de respuesta)
    -- $filterParams (Si se usaron filtros, se agregan)
    */

    function __construct($responseCode,  $mObject, $filterParams, $page, $countTotal) {
        $this->responseCode = $responseCode; 
        $this->mObject = $mObject; 
        $this->filterParams = $filterParams;
        $this->page = $page;
        $this->countTotal = $countTotal;
    }

    public function getCountTotal(){
		return $this->countTotal;
	}

	public function setCountTotal($countTotal){
		$this->countTotal = $countTotal;
	}

	public function getResponseCode(){
		return $this->responseCode;
	}

	public function setResponseCode($responseCode){
		$this->responseCode = $responseCode;
	}

	public function getPage(){
		return $this->page;
	}

	public function setPage($page){
		$this->page = $page;
	}

	public function getMObject(){
		return $this->mObject;
	}

	public function setMObject($mObject){
		$this->mObject = $mObject;
	}

	public function getFilterParams(){
		return $this->filterParams;
	}

	public function setFilterParams($filterParams){
		$this->filterParams = $filterParams;
	}
}
