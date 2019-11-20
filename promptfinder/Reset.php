<?php
include('Connection.php');
	

			$connectobj  = new Connection();
			$connection = $connectobj->doConnection();
			
	
	$stmt = $connection->prepare("delete from banks");
	$stmt->execute();
	//print_r($stmt);
	
	$stmt = $connection->prepare("delete from companys");
	$stmt->execute();
	
	$stmt = $connection->prepare("delete from requests");
	$stmt->execute();
	
	$stmt = $connection->prepare("delete from session_levels");
	$stmt->execute();
?>