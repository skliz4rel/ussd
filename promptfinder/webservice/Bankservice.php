<?php
include("IBankservice.php");
	
	class Bankservice implements IBankservice
	{
		//Declaring variables of the class
		public $endpoint;
		
		function __construct($webserviceurl){
			$this->endpoint = $webserviceurl;
		}
		
		//http://localhost:56175/api/afritalk/111111?Text=400
		
			public function Allbanks(){
		
					$postdata = [];
					$postdata = json_encode($postdata);
										
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/bank/allbanks",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POST => true,
						CURLOPT_POSTFIELDS =>$postdata , 
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
		
		public function Banksbyrange($startrange, $endrange){
		
				$postdata = [ 'id0'=>$startrange, 'id1'=>$endrange ];
					$postdata = json_encode($postdata);
										
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/bank/banksbyrange",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POST => true,
						CURLOPT_POSTFIELDS =>$postdata , 
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
		
		public function Getabank($bankid){
			
			$postdata = [ 'id0'=>$bankid ];
					$postdata = json_encode($postdata);
					
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/bank/Getbank",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POST => true,
						CURLOPT_POSTFIELDS =>$postdata , 
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