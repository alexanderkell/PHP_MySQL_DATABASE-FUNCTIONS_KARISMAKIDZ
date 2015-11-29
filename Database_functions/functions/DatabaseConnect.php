<?php

class DatabaseConnect{
	public function connect($db_host, $db_username, $db_password,$mysql_db){ 
		$mysqli1 = new mysqli($db_host, $db_username, $db_password, $mysql_db);
		if(mysqli_connect_errno()) {
			echo "Connection Failed: " . $mysqli1->connect_errno();
			exit();
		}else{
			return $mysqli1;
		}
	}
}

?>