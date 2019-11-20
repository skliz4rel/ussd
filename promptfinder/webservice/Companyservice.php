<?php
include("ICompanyservice.php");
	
	class Companyservice implements ICompanyservice
	{
		//Declaring variables of the class
		public $endpoint;
		
		function __construct($webserviceurl){		
			$this->endpoint = $webserviceurl;
		}
		
					
		public function Getcompanyname($promptid){
					
			$url = $this->endpoint."api/company/getname/".$promptid;
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$resp = curl_exec($ch);
			curl_close($ch);

				if ($ch){
					return ''.$resp;
				}
			}
	
	}
?>