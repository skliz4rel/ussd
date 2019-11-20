<?php
include("IPersonservice.php");
	
	class Personservice implements IPersonservice
	{
		//Declaring variables of the class
		public $endpoint;
		
		function __construct($webserviceurl){		
			$this->endpoint = $webserviceurl;
		}
		
		//http://localhost:56175/api/afritalk/111111?Text=400
		
			public function Saveperson($phone,$firstname, $lastname,$sex, $email, $password){
					
					$postdata = array('StateID'=>0,'LGAID'=>0,'Address'=>'',
					'phoneNumber' => $phone,'firstname'=>$firstname,'lastname'=>$lastname,'sex'=>$sex,
					'email'=>$email,'password'=>$password, 'confirmPassword'=>$password,'registrationPlatform'=>'ussd',
					"phoneType"=>'',"registrationPlatform"=> '',"activatetoken"=> ''
					);
			
					$postdata = json_encode($postdata);
					
					$secretkey = "pnl";
					//return $postdata;								
					
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/person/createuser",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POST => true,
					  CURLOPT_POSTFIELDS =>$postdata ,					
						CURLOPT_HTTPHEADER => [
							"accept: application/json",
							"cache-control: no-cache",
							"secretkey : ".$secretkey,
							 'Content-Type: application/json',    
							  'Content-Length: ' . strlen($postdata)
					  ]
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					if($err){
					  // there was an error contacting the Paystack API
					  die('Curl returned error: ' . $err);
					}
					
					$tranx = json_decode($response, true);

					return $tranx;					
					
		}
					
		public function Doespersonexits($phone){
				
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/person/checkifregistered/".$phone,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "GET",
					  CURLOPT_POST => false,
					  //CURLOPT_POSTFIELDS => $postdata,
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					if($err){
					  // there was an error contacting the Paystack API
					  die('Curl returned error: ' . $err);
					}
					
					$tranx = json_decode($response, true);

					return $tranx;
		}
		
				public function Getpersoninfos($phone){
				
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/person/Getuserstatus/".$phone,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "GET",
					  CURLOPT_POST => false,
					  //CURLOPT_POSTFIELDS => $postdata,
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					if($err){
					  // there was an error contacting the Paystack API
					  die('Curl returned error: ' . $err);
					}
					
					$tranx = json_decode($response, true);

					return $tranx;
		}
	
/*		public function Getwalletbalance($hotline){
		
			$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/person/getwalletbalance/".$hotline,
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "GET",
					  CURLOPT_POST => false,
					  //CURLOPT_POSTFIELDS => $postdata,
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					if($err){
					  // there was an error contacting the Paystack API
					  die('Curl returned error: ' . $err);
					}
					
					$tranx = json_decode($response, true);

					return $tranx;
		}
		*/
				
		public function Saveaccount($phonenumber, $bankid, $accountnumber, $accountname){
					
			$postdata = [ 'phonenumber'=>$phonenumber,'bankid'=>$bankid, 'accountnumber'=>$accountnumber,'accountname'=>$accountname ];
					$postdata = json_encode($postdata);
					
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/person/Saveaccount",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POST => true,
						CURLOPT_POSTFIELDS =>$postdata,
						CURLOPT_HTTPHEADER => [
							"accept: application/json",
							"cache-control: no-cache",
							//"secretkey : ".$secretkey, This is not needed too
							 'Content-Type: application/json',
							  'Content-Length: ' . strlen($postdata) //since we are not posting data there is no need for this
					  ]
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					if($err){
					  // there was an error contacting the Paystack API
					  die('Curl returned error: ' . $err);
					}
					
					$tranx = json_decode($response, true);

					return $tranx;		
		}
		
		public function Storecard($phonenumber, $cardnum){
		
				$postdata = [ 'phonenumber'=>$phonenumber,'cardnumber'=>$cardnum ];
					$postdata = json_encode($postdata);
					
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/person/Saveaccount",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POST => true,
						CURLOPT_POSTFIELDS =>$postdata,
						CURLOPT_HTTPHEADER => [
							"accept: application/json",
							"cache-control: no-cache",
							//"secretkey : ".$secretkey, This is not needed too
							 'Content-Type: application/json',
							  'Content-Length: ' . strlen($postdata) //since we are not posting data there is no need for this
					  ]
					));

					$response = curl_exec($curl);
					$err = curl_error($curl);

					if($err){
					  // there was an error contacting the Paystack API
					  die('Curl returned error: ' . $err);
					}
					
					$tranx = json_decode($response, true);

					return $tranx;
		}
			
	}
?>