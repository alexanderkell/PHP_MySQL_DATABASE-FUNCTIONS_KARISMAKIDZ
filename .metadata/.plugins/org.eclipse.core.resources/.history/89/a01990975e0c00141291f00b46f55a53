<?php
//error_reporting(0);
require 'DatabaseConnect.php';
require 'Parents.php';

class ParentFunctions{
	function verificationEmail(){
		echo 'hi';
	}
	
	function RegisterParent($email,$password,$title,$sex,$nickname,$firstname,$lastname){
	
		include_once '../config/Config.php';
		
		$conn = new DatabaseConnect();
		$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);
		//check valid email address
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			echo "Please enter a valid email address";
			die();
		}else{
			//md5 level password encryption
			$md5_password=md5($password);
			$hash = md5(rand(1,10000));
			
			$queryEmReg= "SELECT * FROM parents WHERE email ='".$email."'";
			$emailCheck = $mysqli->query($queryEmReg);
			if(!mysqli_num_rows($emailCheck)<1){
				echo 'Email address in use';
			}else{
				$sql = "INSERT INTO parents (email,password,title,sex,nickname,firstname,lastname,hash)
						VALUES (?,?,?,?,?,?,?,?)";
			
				$mail = new Parents();
				//prepared query statements
				if($stmt = $mysqli -> prepare($sql) ){
					$stmt ->bind_param("ssssssss",$email,$md5_password,$title,$sex,$nickname,$firstname,$lastname,$hash);
					$stmt ->execute();
					$stmt ->bind_result($result);
			
					if($stmt->affected_rows>0){
						echo 'Email sent';
						$mail -> VerificationEmail($email, $firstname, $hash);
					} else {
						echo 'Error - could not register';
					}
					$stmt->close();
			
				}else{
					echo 'Failed query';
				}	
			}
		}
		$connect->close();
	}	
}

$obj = new ParentFunctions();
$obj->RegisterParent('alex_kell@hotmail.co.uk','hi','hi','hi','hi','hi','hi');
