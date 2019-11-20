<?php
include("ICollectionservice.php");

//echo "This is teh contant ".webserviceurl;
	
	class Collectionservice implements ICollectionservice
	{
		//Declaring variables of the class
		public $endpoint;
		
		function __construct($webserviceurl){		
			$this->endpoint = $webserviceurl;
		}
		
		//http://localhost:56175/api/afritalk/111111?Text=400
		
			public function Storecollection($phone,$paymethod, $promptid,$totalamount, $quantity, $commidity){
					
					$postdata = array(
					'phonenumber' => $phone,'paymethod'=>$paymethod,'promptid'=>$promptid,'totalamount'=>$totalamount,
					'quantity'=>$quantity,'commodity'=>$commidity
					);
				
					$postdata = json_encode($postdata);
					
					//echo ($postdata); die();
					
					$secretkey = "pnl";
					//return $postdata;								
					
					$curl = curl_init();

					curl_setopt_array($curl, array(
					  CURLOPT_URL => $this->endpoint."api/microcollection/post",
					  CURLOPT_RETURNTRANSFER => true,
					  CURLOPT_CUSTOMREQUEST => "POST",
					  CURLOPT_POST => true,
					  CURLOPT_POSTFIELDS =>$postdata,					
						CURLOPT_HTTPHEADER => [
							"accept: application/json",
							"cache-control: no-cache",
							//"secretkey : ".$secretkey,
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
		
	}
?>