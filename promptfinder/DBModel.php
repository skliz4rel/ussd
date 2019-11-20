<?php
include('IDBModel.php');
include('Messageobj.php');

class DBModel implements IDBModel{
	
	//Declaring the variables of he model class
	private $connection = null;

	function __construct($connection){
		$this->connection = $connection;
	}
	
	/************************Theses are the modules of the requesttest table *********************/
	
	public function Storerequest($text){
		
		$stmt = $this->connection->prepare("INSERT INTO requests (usertext)
			VALUES (?)");
			$stmt->bindParam(1, $text);
			
			$stmt->execute();
			
			$last_insert_id = $this->connection->lastInsertId();
			return $last_insert_id;
	}

	/***********************Emergency modules below *******************************/
	public function Logemergency($phone, $type){
	
		$stmt = $this->connection->prepare("INSERT INTO emergency (phone, type)
			VALUES (?,?)");
			$stmt->bindParam(1, $phone);
			$stmt->bindParam(2, $type);
			
			$stmt->execute();
			
			$last_insert_id = $this->connection->lastInsertId();
			return $last_insert_id;
	}
	
	/************************These modules are for the session table *************************/
	
	public function Getlevelofsession($sessionId,$phonenumber){
	
		$data = [
					'session_id'=>$sessionId,
					'phonenumber'=>$phonenumber
				];
				
		$sql = "select level from session_levels where session_id =:session_id and phone=:phonenumber ";
		
		$result = $this->connection->prepare($sql);
		
		$result->execute($data);
		
		$record = $result->fetch(PDO::FETCH_ASSOC);
		
		return $record['level'];
	}
	
	public function Countsessionbyid($sessionId){
		
		$data = [
					'session_id'=>$sessionId
				];
		
			$sql="SELECT count(*) as 'count' FROM session_levels WHERE session_id=:session_id";
			$result = $this->connection->prepare($sql);
			
			$result->execute($data);
			
			$record = $result->fetch(PDO::FETCH_ASSOC);
			
			return $record['count'];
	}
	
	public function Updatesessionlevel($sessionId,$phoneNumber, $level){
		
			$data = [
				'session_id'=>$sessionId,
				'phonenumber'=>$phoneNumber,
				'level' => $level
			    ];
	
			$sql = "UPDATE session_levels SET
			level = :level
			WHERE session_id=:session_id and phone =:phonenumber";
			
			$stmt = $this->connection->prepare($sql);
			
			$stmt->execute($data);
	}
	
	public function Savesessionlevel($sessionId, $level, $phone){
		
		$stmt = $this->connection->prepare("INSERT INTO session_levels (session_id, phone, level)
			VALUES (?, ?, ?)");
			$stmt->bindParam(1, $sessionId);
			$stmt->bindParam(2, $phone);
			$stmt->bindParam(3, $level);
			
			$stmt->execute();
			
			$last_insert_id = $this->connection->lastInsertId();
			return $last_insert_id;
	}
	
	/*********************************These modules are for the Bank table **********************/
		
		public function Savebank($phonenumber, $bankid){
		
			$acctname = null; $acctnum = null;
			$stmt = $this->connection->prepare("INSERT INTO Banks (bankid, accountname, accountnum, phonenumber)
			VALUES (?, ?, ?, ?)");
			$stmt->bindParam(1, $bankid);
			$stmt->bindParam(2, $acctname);
			$stmt->bindParam(3, $acctnum);
			$stmt->bindParam(4, $phonenumber);
			
			$stmt->execute();
			
			$last_insert_id = $this->connection->lastInsertId();
			return $last_insert_id;
		}
		
		public function Check4bank($phonenumber){
		
			$data = [
					'phonenumber'=>$phonenumber
				];
		
			$sql="SELECT count(*) as 'check' FROM banks WHERE phonenumber=:phonenumber";
			$result = $this->connection->prepare($sql);
			
			$result->execute($data);
			
			$record = $result->fetch(PDO::FETCH_ASSOC);
			
			return $record['check'];
		}
		
		public function Updatebankid($phonenumber, $bankid){
		
			$data = [
				'bankid'=>$bankid,
				'phonenumber' => $phonenumber
			    ];
	
			$sql = "UPDATE Banks SET
			bankid = :bankid
			WHERE phonenumber=:phonenumber";	
			
			$stmt = $this->connection->prepare($sql);
			
			$stmt->execute($data);
		}
		
		
		public function Addacctname($phonenumber, $acctname){
					
			$data = [
				'accountname'=>$acctname,
				'phonenumber' => $phonenumber
			    ];
	
			$sql = "UPDATE Banks SET
			accountname = :accountname
			WHERE phonenumber=:phonenumber";	
			
			$stmt = $this->connection->prepare($sql);
			
			$stmt->execute($data);
		}
		
		public function Addacctnumber($phonenumber, $acctnumber){
		
			$data = [
				'accountnum'=>$acctnumber,
				'phonenumber' => $phonenumber
			    ];
	
			$sql = "UPDATE Banks SET
			accountnum = :accountnum
			WHERE phonenumber=:phonenumber";	
			
			$stmt = $this->connection->prepare($sql);
			
			$stmt->execute($data);
		}
	
		public function Getbankid($phonenumber){
		
			$data = [
					'phonenumber'=>$phonenumber
				];
		
			$sql="SELECT bankid FROM banks WHERE phonenumber=:phonenumber";
			$result = $this->connection->prepare($sql);
			
			$result->execute($data);
			
			$record = $result->fetch(PDO::FETCH_ASSOC);
			
			return $record['bankid'];
		}
		
		public function Getbank($phonenumber){
			
			$data = [
					'phonenumber'=>$phonenumber
				];
		
			$sql="SELECT * FROM banks WHERE phonenumber=:phonenumber";
			$result = $this->connection->prepare($sql);
			
			$result->execute($data);
			
			$record = $result->fetch(PDO::FETCH_ASSOC);
			
			return $record;
		}
		
}
?>