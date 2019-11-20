<?php

	interface IPersonservice
	{
	public function Saveperson($phone,$firstname, $lastname,$sex, $email, $password);
	
	public function Doespersonexits($phonenumber);
	
	public function Getpersoninfos($phonenumber);
		
	public function Saveaccount($phonenumber, $bankid, $accountnumber, $accountname);
	
	public function Storecard($phonenumber, $cardnum);
	}

?>