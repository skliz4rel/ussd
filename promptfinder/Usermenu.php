<?php
//apis4pay.com apis4payment.com  paydisrupt.com  paydron.com paysnippet.com payverbs.com
include("webservice/Collectionservice.php");

	class Usermenu{
	
	//declaring the variables of the class
	private $sessionId;
	public $phoneNumber;
	public $serviceCode;
	public $text;
	public $usersReponse;
	private $dbmodel;
	private $level;
	private $webserviceurl;
	private $gotUserfeedback;
	
	private $textArray;
	
	function __construct($sessionId,$phoneNumber, $text, $usersReponse, $dbmodel, $level,$webserviceurl){
		
		$this->sessionId = $sessionId;
		$this->phoneNumber =$phoneNumber;
		$this->text = $text;
		$this->usersResponse= $usersReponse;
		$this->dbmodel = $dbmodel;
		$this->level= $level;
		$this->webserviceurl = $webserviceurl;
		
		if (strpos($this->text, '*') !== false){
				$this->textArray=explode('*', $this->text);
				$this->userResponse=trim(end($this->textArray));
				$this->gotUserfeedback = true;
		}
	
	}
	
	public function GetResponse(){
	
		$response = '';
		
		if($this->text == ""){

				 $response  = "CON Welcome to Frutga Detox Limited\nBuy your Fruit Detox drinks now \n";
				 $response .= "1. Buy Frutga Drink (1 Bottle cost N 1000)\n";
				 $response .= "2. Buy FrutgaX Drink (1 Bottle cost N 2000) \n";
				 $this->logSession('prebuy');
			}
			
		else if($this->text[0] == "1"){
				
				$name = "frutga";
				$response = $this->collectorder($name);
				
		}		
		
		else if($this->text[0] == "2"){
				$name = "frutgax";
				$response = $this->collectorder($name);				
		}
				
		return $response;
	}
		
	private function collectorder($name){
	
		$response = "";
	
		if($this->gotUserfeedback == false){	
		
			$response  = "CON Enter Quantity of {$name} that you want ?\n";
			
			$this->logSession('amount');
		}
		else{
			if($this->level == 'amount'){
			$response  = "CON How much are you paying for {$name}, (figures only)\n";
			
			$this->logSession('done');
			}
			
			if($this->level == 'done'){
			
				$quantity = $this->textArray[1];
				$amount = (int)$this->textArray[2];
				
				//echo $quantity." amount ".$amount; die();
				
				$paymethod = "bank"; $promptid = "pnl"; $commodity=$name;
				//we are going to post to the server here
				$webservice = new Collectionservice($this->webserviceurl);
				$webresult = $webservice->Storecollection($this->phoneNumber,$paymethod, $promptid,$amount, $quantity, $commodity);
				//if($webresult['status'] == "success")
				
				$response = "END You successfully placed an order for {$quantity} {$name} which cost N {$amount}\n Please note that this is a demo so your account won't be charged";
				
				//else
				//	$response = "END Order failed please try again.";
			}
		}
							
		return $response;
	}
		
	//This is the private function
	private function logSession($level){
			
			if(empty(trim($this->level)) || strlen(trim($this->level)) < 1){
				
				$this->dbmodel->Savesessionlevel($this->sessionId, $level, $this->phoneNumber);				
			}
			else {
				$this->dbmodel->Updatesessionlevel($this->sessionId,$this->phoneNumber, $level);
			}
	}
}
?>