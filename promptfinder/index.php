<?php
include('Connection.php');
include('DBModel.php');
include('Usermenu.php');
include('webservice/Personservice.php');
include('webservice/Companyservice.php');
include('webservice/Bankservice.php');
include('webservice/Cardservice.php');

class USSDMenu{

	//declaring the variables of the code
	public $sessionId;
	public $phoneNumber;
	public $serviceCode;
	public $text;  
	//This is going to store the unformated text
	public $unformattedtext;
	public $usersReponse;
	private $dbmodel;
	private $level;
	private $textArray;
	
	//Webservice objects
	private $companyservice;
	private $personservice;
	private $bankservice;
	private $cardservice;
	
	private $webserviceurl;
	
	function __construct(){
	
		//$this->webserviceurl = "http://localhost:52060/";
		$this->webserviceurl ='http://promptfindershopbranch.azurewebsites.net/';
	
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
			$this->personservice = new Personservice($this->webserviceurl);
			$this->companyservice= new Companyservice($this->webserviceurl);
			$this->bankservice = new Bankservice($this->webserviceurl);
			$this->cardservice = new Cardservice($this->webserviceurl);
		
			$connectobj = new Connection();
			$connection = $connectobj->doConnection();
			$this->dbmodel = new DBModel($connection);
		
			$this->text = $_POST["text"];
			
			$this->unformattedtext = $this->text;  //We keep this here for record purpose
			
			//We would convert phone number to local format
			$this->phoneNumber = str_replace("+234","0",$this->phoneNumber);			
			
			//collect the current level
			$id = $this->dbmodel->Storerequest($this->text);
		
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
			
			$this->level = $this->dbmodel->Getlevelofsession($this->sessionId,$this->phoneNumber);
			
			if($this->level == null ){
				$this->level = 0;				
			}
			
			//echo "The level is here ".$this->level;
			
			$objcall = null;//This object would be used to call the class depending on the process flow we need
			
			$userrecord = $this->personservice->Getpersoninfos($this->phoneNumber);
		
			/*******************************Menu for Ones ************************************/
			
			$response = "";
			
			//echo "This is the value that is passed  ".$userrecord ['status'];
			//print_r($userrecord);
			
			if($userrecord ['status']  == 'notregistered')
				$response = $this->GetResponse($this->textArray);
				
			else if($userrecord ['status']  == 'registered' && ($userrecord ['data']['hasbank'] == 0 and $userrecord ['data']['hascard'] == 0)){
			
				$response = $this->GetResponseforpayment($this->textArray);
			}
			
			else if($userrecord ['status']  == 'registered' && ($userrecord ['data']['hasbank'] == 1 or $userrecord ['data']['hascard'] == 1)){
				$objt = new Usermenu($this->sessionId,$this->phoneNumber, $this->unformattedtext, $this->usersReponse, $this->dbmodel, $this->level, $this->webserviceurl);
				$response = $objt->GetResponse();
			}
			
			/******************************Second level Menu below ****************************************************/
			//echo "This is the value that is passed  ".$this->text;

			
			// Print the response onto the page so that our gateway can read it
			header('Content-type: text/plain');
			echo $response;
			
			}
	}
	
	
	private function GetResponse($textArray){
	
	//print_r($textArray);
	
		$response = '';
		switch($this->text){
			case "":
				 $response  = "CON Welcome to FrutgaX, a business registered on Promptfinder. \n";
				 $response .= "1. Signup to place an order for Frutga Drinks \n";
				 $response .= "2. About Frutga Company \n";
				 $response .= "3. Help \n";
			break;
		
			case "1":
			//echo $this->gotUserfeedback;
					
					if($this->gotUserfeedback == false){
						$response = "CON Enter your Firstname\n";

						//Store the level here
						$this->logSession("firstname");
					}
					else{
						//echo "I am in here my friend";
						
						if($this->level == 'firstname'){
							$this->logSession("lastname");
							
							$response = "CON Enter your Lastname.\n";
						}
						
						if($this->level =="lastname"){
						
							$this->logSession("sex");
							
							$response = "CON Enter your Sex (Please enter male or female).\n";
						}
						
						if($this->level == 'sex'){
							$this->logSession("email");
							
							$response = "CON Enter email address (If you dont have enter none).\n";
						}
						
						if($this->level == 'email'){
							$this->logSession("password");
							
							$response = "CON Enter password.\n";
						}
						
						if($this->level == 'password'){
							
							$firstname = $textArray[1];
							$lastname = $textArray[2];
							$sex = $textArray[3];
							$email = $textArray[4];
							$password = $textArray[5];
						
							//$message = $this->userResponse;
							//print_r ();
						
							//print_r($textArray);
							//echo "<br/>"; die();
							//$this->dbmodel->Storeissue($this->phoneNumber,$subject, $message);
							$result = $this->personservice->Saveperson($this->phoneNumber,$firstname, $lastname,$sex, $email, $password);
							
							if($result['status'] == 'success')
								$response = $this->returnPaymentoptionmenu();
							else
								$response  = "END Try again your account was not created";
							
							//We would reset the set string
							$this->text = "4";
							
							$this->logSession("choosebank");
						}											
					}					
			break;
								
			case "2":				
					$response  = "END Frutga is a Fruit drink company that sells detox drinks \n";					
			break;
		
			case "3":			
				$response = "END Follow the steps\n";				
				$response .= "Step 1. Register as a customer\n";
				$response .= "Step 2. Provide your Bank details or Card details to place an order\n";
				$response .= "Step 3. Place an order\n";				
				
				//Store the level here
				$this->logSession("done");
			break;
			
		}
	
		//echo $this->text."  am here friend {$this->level}";
		
		return $response;
	}
	
	//This method is going to be used for bank or card details signup
	public function GetResponseforpayment($textArray){
	
		//echo "This is the value that is passed  ".$this->text;

		$response = '';
		
			if($this->text == ''){
				$response = $this->returnPaymentoptionmenu();
				
				$this->logSession("choosebank");
			}
		
			if($this->text ==  "1*5" or $this->text == "5"){
			
				if($this->level == 'choosebank' and $this->gotUserfeedback == false){
									//echo "CON here  now $this->level   $this->text ";
					$startrange = 1; $endrange = 7;
					
					$banks = $this->bankservice->Banksbyrange($startrange, $endrange);
					
					$response = $this->Getresponsefromarray($banks);
					
					$response .= "\n";
					$response .= "press 1 for more";
				}
				else if($this->gotUserfeedback == true ){
					$response = $this->Storebank();
				}
			}
			
			if( $this->text == "1*5*1" or $this->text == "5*1"){
			
				if($this->level == 'choosebank'  and $this->gotUserfeedback == false){
					$startrange = 8; $endrange = 15;
					
					$banks = $this->bankservice->Banksbyrange($startrange, $endrange);
					
					$response = $this->Getresponsefromarray($banks);
					
					$response .= "\n";
					$response .= "press 1 for more";
				}
				else if($this->gotUserfeedback == true ){
					$response = $this->Storebank();
				}
			}
			
			if($this->text == "1*5*1*1" or $this->text == "5*1*1"){
			
				if($this->level == 'choosebank'  and $this->gotUserfeedback == false){
					$startrange = 15; $endrange = 23;
					
					$banks = $this->bankservice->Banksbyrange($startrange, $endrange);
					
					$response = $this->Getresponsefromarray($banks);
					
					$response .= "\n";
					$response .= "Enter a bank code or press 1 to go back";
					
					$this->text = "5";
				}
				else if($this->gotUserfeedback == true ){
					$response = $this->Storebank();
				}
			}
		
		if($this->text == "1*6" or $this->text == "6"){
		//echo "This is the value that is passed  ".$this->text;		
			if($this->level == 'choosebank' and $this->gotUserfeedback == false ){
				$response = "CON Enter card number";
			}
			else if($this->level == 'choosebank' and $this->gotUserfeedback == true ){
				$this->logSession("cardnumber");
				
				$cardnum = $this->userResponse;
				
				//We are going to be storing card details at this point
				$result = $this->cardservice->Savecard($this->phoneNumber,$cardnum);
				//print_r($result); die();
				
				if($result['status'] == 'created')
					$response = "END You have successfully connected your card for purchases. Our Platform is protected under PCI DSS compliant and All cards are secured, dial *347*17# to shop from Frutga Drink Entreprises";
				else
					$response= "END Failed to connect your card, please redial the code to connect card or bank account to buy from street sellers ";
			}
		 }
	   		
		//echo "here we dey friend  ".count($this->textArray);
		//echo "<br/>  $this->text it is friend "; die();
	
		//We are going to check if the user confirms the bank account here
		if((substr($this->text,0,2) == "5*" or substr($this->text,0,3) == "1*5") and $this->text[strlen($this->text)-1]== "2"){
			//echo "get it here friend";
			
			//Right here we are going to send the bank information to the server
			$bank = $this->dbmodel->Getbank($this->phoneNumber);
			$result = $this->personservice->Saveaccount($this->phoneNumber, $bank['bankid'], $bank['accountnum'], $bank['accountname']);
	
			$this->text="";
			//$objt = new Usermenu($this->sessionId,$this->phoneNumber,$this->text, $this->usersReponse, $this->dbmodel, $this->level, $this->webserviceurl);
			//$response = $objt->GetResponse();		
			$response = "END Successfully registered your account for payment\nKindly redial *347*17# to start buying from Frutga Drinks Enterprises";
		}
	
	return $response;
  }
			
	//This is a private function to help store an information in the database
	private function Storebank(){
			//echo "here you are friend  $this->userResponse";
			
			$response = "";
	
			if(strlen($this->userResponse) >= 2 && strlen($this->userResponse) < 4){
				$bankid = (int)$this->userResponse; //We would cast the bank code to an integer here
				
				//echo "This is the bank id ".$bankid;
				//We would store the bank code on the client side
				$check = $this->dbmodel->Check4bank($this->phoneNumber);
				
				if($check == false)
					$this->dbmodel->Savebank($this->phoneNumber, $bankid);
				else
					$this->dbmodel->Updatebankid($this->phoneNumber, $bankid);
				
				//$this->text = "5*2*{$this->userResponse}";//Here we would alter user selection
				$response = "CON Enter your Account number";
				$this->logSession("acctnumber");
			}
			else if(strlen($this->userResponse) > 4){
					$acctnumber = $this->userResponse;
						
						$this->dbmodel->Addacctnumber($this->phoneNumber, $acctnumber);
						
						$bankid = $this->dbmodel->Getbankid($this->phoneNumber);
						
						//We are going to query the account name here. From the webservice we are suppose to also confirm the name of the user
						$bank = $this->bankservice->Getabank($bankid);
						
						$response = "CON ".$bank['Name']."\n";
						$response .= "{$acctnumber}\n";
						$response .= ""; //The user or customer's account name should be placed here for confirmation sake
						$response .= "Press 2 to confirm your account\n";					
						
					$this->logSession("confirmacct");
			}
			
			return $response;
	}
	
	//This is the private function
	private function logSession($level){
			//echo "<br/>This is the ".$level.' go for it now    '.$this->level."<br/>";
			
			if(empty(trim($this->level)) || strlen(trim($this->level)) < 1){
				//echo "in here hidding 1111";
			
				//echo "++++++++++++++++++++++++++ ";
				$this->dbmodel->Savesessionlevel($this->sessionId, $level, $this->phoneNumber);				
			}
			else {
				//echo "================================";
				
				//echo "in here hidding kkkkk";
				$this->dbmodel->Updatesessionlevel($this->sessionId,$this->phoneNumber, $level);
			}
		}
		
	public function Getresponsefromarray($array){
	
		$response = "CON ";
		
		if(is_null($array) == false)
		foreach($array as $obj){
			$response .= "0".$obj['ID']." ".$obj['Value']."\n";
		}
		
		return $response;
	}
	
	public function returnPaymentoptionmenu(){
		$this->text = "";
	
		$response = "CON You have successfully register please provide your bank or card details so you can place an order.\n";
					$response .= "5. Enter bank details\n";
					$response .= "6. Enter card details";
							
		return $response;
	}
	
}

if(!empty($_POST))
	$initiateobj = new USSDMenu();
?>