<?php

	interface IDBModel
	{

	/************************Theses are the modules of the requesttest table *********************/
	
		public function Storerequest($text);
		
		/************************These modules are for the session table *************************/
		public function Getlevelofsession($sessionId,$phonenumber);
		
		public function Countsessionbyid($sessionId);
		
		public function Updatesessionlevel($sessionId,$phoneNumber, $level);
		
		public function Savesessionlevel($sessionId, $level, $phone);
		
		/*********************************These modules are for the Bank table **********************/
		
		public function Savebank($phonenumber, $bankid);
		
		public function Check4bank($phonenumber);
		
		public function Updatebankid($phonenumber, $bankid);
		
		public function Addacctname($phonenumber, $acctname);
		
		public function Addacctnumber($phonenumber, $acctnumber);
		
		public function Getbankid($phonenumber);
		
		public function Getbank($phonenumber);
	}
?>