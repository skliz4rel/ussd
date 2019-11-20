<?php
include('Connection.php');
include('DBModel.php');

$connectobj  = new Connection();
$connection = $connectobj->doConnection();
$dbmodel = new DBModel($connection);

$num = "1*5*2";
echo substr($num,0,3); echo "<br/>";
echo $num[strlen($num)-1];
echo "<br/>";

if($num == "2" or $num == "1*5*2"){
	echo "here friend ";
}

echo count($num);

/*
$id = '012'; $id = (int)$id;
echo $id;


$string = "4*01111";
echo "<br/>";
$sub = $string[0].$string[1].$string[2];
echo (substr($string, 0, 3));
echo "<br/>";

$array = [1,2,3,4,5,6,7,8];

foreach($array as $num){
	echo "This is the number ".$num."<br/>";
}
*/
if(isset($_GET['checkacct'])){

	$check = $dbmodel->Check4bank('08131528807');
	
	echo $check;
}

if(isset($_GET['updatebank'])){
	
	$dbmodel->Updatebankid('08131528807', '4');

}

//This would be used to test the Database model class.
if(isset($_GET['checkreg'])){
	$check = $dbmodel->Isuserregistered('08131528807');
	echo $check;
}

if(isset($_GET['checklevel'])){
	
	$check = $dbmodel->Getlevelofsession("111111111");
	echo "This is here ".$check;
}

if(isset($_GET['updatelevel'])){
	
	$dbmodel->Updatesessionlevel('1234', '500');
}

if(isset($_GET['savelevel'])){
	
	$dbmodel->Savesessionlevel('2244', '6000', '08160841376');
}

if(isset($_GET['storeuser'])){
	
	$dbmodel->Storeuser('081224241234','2342342','','',1);
}

if(isset($_GET['addacct'])){
	$dbmodel->Savebank('08131528807', 1);	
}

if(isset($_GET['addacctname'])){
	$dbmodel->Addacctname('08131528807','jide akin');	
}

if(isset($_GET['addacctnum'])){
	$dbmodel->Addacctnumber('08131528807','0123456789');	
}

if(isset($_GET['getbankid'])){
	echo $dbmodel->Getbankid('08131528807');	
}

if(isset($_GET['getbank'])){
	print_r ($dbmodel->Getbank('08131528807'));
}

?>