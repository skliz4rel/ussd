<?php
/*
include('Newuser.php');
include('Registereduser.php');
*/
include('webservice/Webservice.php');
include('Connection.php');
include('DBModel.php');
include('Usermenu.php');

class USSDMenu{

	//declaring the variables of the code
	public $sessionId;
	public $phoneNumber;
	public $serviceCode;
	public $text;
	public $usersReponse;
	private $dbmodel;
	private $level;
	private $textArray;
	
	//We would use this variable to store the unchanged response
	private $unchangedresp = "";
	
	private $webservice;
	
	function __construct(){
	
		//$this->webservice = new Webservice();
		
		$response=  "";
		$this->gotUserfeedback = false;
		
		//initializing the variables of the code
		if(isset($_POST["sessionId"]))
				$this->sessionId = $_POST["sessionId"];
			
		if(isset($_POST["phoneNumber"]))
			$this->phoneNumber = $_POST["phoneNumber"];
			
		if(isset($_POST["serviceCode"]))
			$this->serviceCode =  $_POST["serviceCode"];
		
		if(isset($_POST["text"])){
			$connectobj  = new Connection();
			$connection = $connectobj->doConnection();
			$this->dbmodel = new DBModel($connection);
		
			$this->text = $_POST["text"];  $unchangedresp = $_POST["text"]; 
			
			//collect the current level
			$id = $this->dbmodel->Storerequest($this->text);
			//$id = $this->webservice->Logafritext($this->text);
			
		//echo 'not Formatted result   '.$this->text.'<br/>';
		
		
		//This is suppose to get the response from the user when we are expecting a feedback
			if (strpos($this->text, '*') !== false){
				$this->textArray=explode('*', $this->text);
				$this->userResponse=trim(end($this->textArray));
				
				//Now we would need to format the string again
				if(strlen($this->userResponse) > 1){
					$needle = "*".$this->userResponse;
					$this->text = str_replace($needle,'',$this->text);
					
					$this->gotUserfeedback = true;
				}
				
				$newresponse = '';
				if($this->textArray !=null){
				foreach($this->textArray as $value){
						if(strlen($value) == 1)
							$newresponse .= $value.'*';
					}
					
					$this->text = $newresponse;
				}
				
				if($this->text != null){
					$this->text=rtrim($this->text,"*");
				}
				
			}

			//echo $this->text .' this is here my friend';
		
			
			$this->level = $this->dbmodel->Getlevelofsession($this->sessionId);
			//$this->level = $this->webservice->Getlevelofsession($this->sessionId);
			
			if($this->level == null ){
				$this->level = 0;
				
				//echo "8888888888888";
			}
			
			//echo "The level is here ".$this->level;
			
			$objcall = null;//This object would be used to call the class depending on the process flow we need
			
			/*****************************CHECK IF A user tries to pay a seller directly ****/
			//echo  strlen($unchangedresp);
			if(strlen($unchangedresp) > 8 && substr($unchangedresp, 0, 8) === "*347*17*"){
				$response = "END You are trying to pay a merchant, this functionality current under development we are integrating with our payment gateways. Coming soon !!";				
			}
			else{
			/*******************************Menu for Ones ************************************/
			//echo "Got here my friend";
			
				//Check for registered user menu
				$formatphone = str_replace("+","_",$this->phoneNumber);
				$check = $this->Userregstatus($formatphone);
				
				if($check == true){
					//echo 'This is the line of the text here ................> '.$this->text;
					
					$objt = new Usermenu($this->phoneNumber, $this->text, $this->usersReponse, $this->dbmodel, $this->level);
					$response = $objt->GetResponse($this->text);
					
					//echo "Got here my friend";
				}
				else{
					//echo "Got here my friend";
				
					$response = $this->GetResponse($this->textArray);
				}
			}
			/******************************Second level Menu below ****************************************************/
			
			
			// Print the response onto the page so that our gateway can read it
			header('Content-type: text/plain');
			echo $response;
			
			}
	}
	
	private function Userregstatus($phone){
		
		$status = $this->dbmodel->Getuser($phone);
		//$status = $this->webservice->Doespersonexits($phone);
		
		if($status != null){
			return true;
		}
		else
			return false;
	}
	
	
	private function GetResponse($textArray){
	
	//print_r($textArray);
	
		$response = '';		
		
		switch($this->text){
			case "":
				 $response  = "CON Welcome to FrutgaX, a business registered on Promptfinder. \n";
				 $response .= "1. Signup to place an order for Frutga \n";
				 $response .= "2. About Frutga Company \n";
				 $response .= "3. Help \n";	
			break;
		
			case "1":
					$response = "END Please wait this would available in 2 days time, Servers undercontruction.\n";
								
			break;
					
			case "2":
			
				$response = "END Frutga is a Natural Detox drink company that specializes in making Natural Detox drink for wellness and fitness from fruit extract.\n";
			break;
		
			case "3":			
				$response = "END You are to sign up to place order for the drink\n";				
				$response .= "1. Follow Step 1 to sign up\n";
				$response .= "2. Please note that sign up is going to be available in 3 days time bear with us\n";
								
				//Store the level here
				$this->logSession("help");
			break;			
						
		}
		
		return $response;
	}
	
	//This is the private function
	private function logSession($level){
			//echo "<br/>This is the ".$level.' go for it now    '.$this->level;
			
			if(empty(trim($this->level)) || strlen(trim($this->level)) < 1){
				//echo "in here hidding 1111";
			
				//echo "++++++++++++++++++++++++++ ";
				$this->dbmodel->Savesessionlevel($this->sessionId, $level, $this->phoneNumber);
				//$this->webservice->Savesessionlevel($this->sessionId, $level, $this->phoneNumber);
			}
			else {
				//echo "================================";
				
				//echo "in here hidding kkkkk";
				//$this->webservice->Updatesessionlevel($this->sessionId, $level);
			}
			
		}
}

if(!empty($_POST))
	$initiateobj = new USSDMenu();
?>