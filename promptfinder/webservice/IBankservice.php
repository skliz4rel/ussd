<?php

	interface IBankservice
	{
	
	public function Allbanks();

	public function Banksbyrange($startrange, $endrange);
	
	public function Getabank($bankid);
	
	
	
	}

?>