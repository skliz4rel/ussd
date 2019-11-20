<?php
include('webservice/Personservice.php');
include('webservice/Bankservice.php');
include('webservice/Companyservice.php');
include('webservice/Collectionservice.php');

	$webserviceurl = "http://localhost:52060/";
	//$webserviceurl ='http://promptfindershopbranch.azurewebsites.net/';

$pobject = new Personservice($webserviceurl);
$bobject = new Bankservice($webserviceurl);
$cobject = new Companyservice($webserviceurl);
$mobject = new Collectionservice($webserviceurl);

if(isset($_GET['collectservice'])){
	$phone = "08131528807"; $paymethod = "card"; $promptid="akindejoye";
	$totalamount = 100;  $quantity  = "1 bottle";$commidity = "rice";

	$result  =$mobject->Storecollection($phone,$paymethod, $promptid,$totalamount, $quantity, $commidity);
	
	print_r($result);
}

if(isset($_GET['allbanks'])){
	$bankarray =  $allbanks = $bobject->Allbanks();
	
	//We are going to seed the back array in to the bank table
	
	print_r($allbanks);
}

if(isset($_GET['getbank'])){
	$bank = $bobject->Getabank('1');
	
	print_r($bank);
	//echo ($bank['Name']);
}


//This would be used to test the Database model class.
if(isset($_GET['createuser'])){
	$obj = $pobject->Saveperson('0891112222','Fela', 'Dorutoye','male', 'felakemi4@uvx.com', 'akinbode1');
	
	print_r($obj);
	
	
}

//089232323232

if(isset($_GET['storeacct'])){
	$phonenumber = "089232323232"; $bankid=1; $accountnumber ="012345689";$accountname="Akindejoye Olajide";
	$check = $pobject->Saveaccount($phonenumber, $bankid, $accountnumber, $accountname);
	
	print_r($check);
}

if(isset($_GET['hasuser'])){
	$check = $pobject->Doespersonexits('08131528807');
	
	print_r($check);
}

if(isset($_GET['userinfo'])){
	$obj = $pobject->Getpersoninfos('08131528807');
	
	print_r($obj);
	
	echo "<br/>";
	
	echo $obj['status']."<br/>";
	echo $obj['data']['hasbank']."<br/>";
	echo $obj['data']['hascard']."<br/>";
}


if(isset($_GET['getcompuser'])){
	$check = $cobject->Getcompanyname('pnl');
	
	print_r($check);
}

?>