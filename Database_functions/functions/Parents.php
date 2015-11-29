<?php
include_once 'DatabaseConnect.php';
//include 'RegisterParent.php';
class Parents{
	
	function alexPHP(){		
		if($result = $db->query("SELECT * FROM people")){
			if($count = $result->num_rows){
				echo $count;
				$rows = $result->fetch_assoc();
				echo '<pre>', print_r($rows), '<pre>';
			}
		}
	}
	
	function VerificationEmail($email, $name, $hash){
		$to = $email;
		$subject = 'Karisma Kidz verification';
		$message = 'Hi '. $name . '/n 
				Thank you for signing up, your account has been created. \n
				You can login with your email address ' .$email. '\n\n
				Please click this link to verify your email:\n
				http://www.karismakidz.co.uk/verify.php?email='.$email.'&hash='.$hash.' ';
		$headers = 'From noreply@karismakidz.co.uk';
		mail($to, $subject, $message, $headers);	
	}
	
	function SendForgotPasswordEmail($email){
		include_once '../config/Config.php';
		
		$conn = new DatabaseConnect();
		$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);
		
		$queryHash = "SELECT hash FROM parents WHERE email =?"; 
		if($stmt1 = $mysqli->prepare($queryHash)){
			$stmt1->bind_param("s",$email);
			$stmt1->execute();
			$stmt1->bind_result($hash);
			$stmt1->fetch();
		}
		
		$to = $email;
		$subject = 'Password reset - Karisma Kidz';
		$message = 'To reset your password please click the following link:\n
					www.karismakidz.co.uk/password_reset.php?email='.$email.'&hash='.$hash.';
				';
		$headers = 'From noreply@karismakidz.co.uk';
		mail($to, $subject, $message, $headers);

		$mysqli->close();
	}
	
	function RelativeVerification($email, $name){
		$to = $email;
		$subject = 'Karisma Kidz Addition';
		$message = 'Hi '. $name . '/n
				You have been sent this email because somebody has signed you up to karisma kidz. \n
				You can continue to sign up to your account with your email: ' .$email. '\n\n
				Please click this link to complete your account sign up:\n
				http://www.karismakidz.co.uk/RegisterParent.php?email='.$email.'&name='.$name.' ';
		$headers = 'From noreply@karismakidz.co.uk';
		mail($to, $subject, $message, $headers);
	}
	
	function UpdateParentAccount($Password, $NickName, $FirstName, $LastName, $Email, $Password, $Sex, $Title){
		include_once '../config/Config.php';
		$conn = new DatabaseConnect();
		$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);
		$mysqli2=$conn->connect($db_host, $db_username, $db_password, $mysql_db);
		
		
		$encPass = md5($Password);
		$Email = 'alex_kell@hotmail.co.uk';
		$pass = "SELECT password FROM parents 
				WHERE Email = ? AND Password = ?";
		
		if($stmt = $mysqli->prepare($pass)){
			$stmt->bind_param("ss",$Email,$encPass);
			$stmt->execute();
			$stmt->bind_result($login);
			$stmt->fetch();

			if($login){
				echo 'Successfully logged in.\n';
				
				$updateQuery = "UPDATE parents
								SET NickName = ?, FirstName = ?, LastName = ?, Sex = ?, Title = ?
								WHERE Password = ? AND Email = ?";
				
				if($upd = $mysqli2->prepare($updateQuery)){
					$upd->bind_param('sssssss', $NickName, $FirstName, $LastName, $Sex, $Title, $encPass, $Email);
					$upd->execute();
					$upd->bind_result($login);
					$upd->fetch();
					echo 'Updated fields';
				}else{
					echo 'Could not update fields';
				}				
			}else{
				echo 'Account details do not exist, please try again.';
			}
		}
		$mysqli->close();
		$mysqli2->close();
	}

	
	
	function LoginParent($Email, $Password){
		include_once '../config/Config.php';
		$conn = new DatabaseConnect();
		$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);		
		$encPass = md5($Password);
		$array = array();
		$query = "SELECT * FROM parents 
				WHERE Email = '".$Email."' AND Password = '".$encPass."'";
		
		$result = mysqli_real_escape_string($mysqli,$query);	

		if($result=mysqli_query($mysqli,$query)){
			while($obj = mysqli_fetch_object($result)){
				$array[]=$obj;
			}
			echo '{"parents":'.json_encode($array).'}';		
		}
		$mysqli->close();
	}
	
	function UpdateParentAccountOther($Email, $ChildIDs, $tasksStarted, $TasksComplete){
		include_once '../config/Config.php';
		$conn = new DatabaseConnect();
		$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);

		$updateQuery = "UPDATE parents
						SET ChildIDs = ?, TasksSet = ?, TasksComplete = ?
						WHERE Email = ?";
		
		if($upd = $mysqli->prepare($updateQuery)){
			$upd->bind_param('ssss', $ChildIDs, $tasksStarted, $TasksComplete, $Email);
			$upd->execute();
			$upd->bind_result($login);
			$upd->fetch();
			echo 'Updated fields';
		}else{
			echo 'Could not update fields';
		}
		
		$mysqli->close();
	}	
	

	function parentFamilyAdd($Email, $childUser){

		include '../config/Config.php';
		$conn = new DatabaseConnect();
		$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);
		
		$querypCheck= "SELECT * FROM Families WHERE Child1 ='".$childUser."' OR Child2 ='".$childUser."' 
				OR Child3 ='".$childUser."' OR Child4 ='".$childUser."' OR Child5 ='".$childUser."'";
		if($parentCheck = $mysqli->query($querypCheck)){
				
			if(!mysqli_num_rows($parentCheck)<1){
				echo 'Family database already exists<br>';
		
				$cCheck1= "SELECT Child1 FROM Families WHERE Parent1 ='".$parentEmail."' AND Child1 = ''";
				$cCheck_1 = $mysqli->query($cCheck1);
				$cCheck2= "SELECT Child2 FROM Families WHERE Parent1 ='".$parentEmail."' AND Child2 = ''";
				$cCheck_2 = $mysqli->query($cCheck2);
				$cCheck3= "SELECT Child3 FROM Families WHERE Parent1 ='".$parentEmail."' AND Child3 = ''";
				$cCheck_3 = $mysqli->query($cCheck3);
				$cCheck4= "SELECT Child4 FROM Families WHERE Parent1 ='".$parentEmail."' AND Child4 = ''";
				$cCheck_4 = $mysqli->query($cCheck4);
				$cCheck5= "SELECT Child5 FROM Families WHERE Parent1 ='".$parentEmail."' AND Child5 = ''";
				$cCheck_5 = $mysqli->query($cCheck5);
		
				if(!mysqli_num_rows($cCheck_1)<1){
					$addonQuery1 = "UPDATE `Families` SET `Child1` = '".$user."'
									WHERE `Parent1` = '".$parentEmail."' OR `Parent2` = '".$parentEmail."'";
					if($addChild1 = $mysqli->query($addonQuery1)){
						echo 'Registered child account - 1st Child<br>';
					}else{
						echo 'died';
					}
				}else if(!mysqli_num_rows($cCheck_2)<1){
					$addonQuery2 = "UPDATE `Families` SET `Child2` = '".$user."'
									WHERE `Parent1` = '".$parentEmail."' OR `Parent2` = '".$parentEmail."'";
					if($addChild2 = $mysqli->query($addonQuery2)){
						echo 'Registered child account - 2nd Child<br>';
					}
				}else if(!mysqli_num_rows($cCheck_3)<1){
					$addonQuery3 = "UPDATE `Families` SET `Child3` = '".$user."'
									WHERE `Parent1` = '".$parentEmail."' OR `Parent2` = '".$parentEmail."'";
					if($addChild3 = $mysqli->query($addonQuery3)){
						echo 'Registered child account - 3rd Child<br>';
					}
				}else if(!mysqli_num_rows($cCheck_4)<1){
					$addonQuery4 = "UPDATE `Families` SET `Child4` = '".$user."'
									WHERE `Parent1` = '".$parentEmail."' OR `Parent2` = '".$parentEmail."'";
					$addChild4 = $mysqli->query($addonQuery4);
					if($addChild4 = $mysqli->query($addonQuery4)){
						echo 'Registered child account - 4th Child<br>';
					}
				}else if(!mysqli_num_rows($cCheck_5)<1){
					$addonQuery5 = "UPDATE `Families` SET `Child5` = '".$user."'
									WHERE `Parent1` = '".$parentEmail."' OR `Parent2` = '".$parentEmail."'";
					$addChild5 = $mysqli->query($addonQuery5);
					if($addChild5 = $mysqli->query($addonQuery5)){
						echo 'Registered child account - 5th Child<br>';
					}
				}else
					echo "Family database full, please select a new parent address.<br>";
				die();
					
			}else{
				echo 'Could not query database';
			}
				
		}else{
			//Place parent account as relative (yet to be activated)
			$familyQuery = "INSERT INTO Families (Child1) VALUES (?)";
			if($stmt1 = $mysqli -> prepare($familyQuery) ){
				$stmt1 ->bind_param("s",$user);
				$stmt1 ->execute();
				$stmt1 ->bind_result($result);
				$stmt1->close();
				echo 'Family account opened by Child';
			}else{
				echo 'Failed query'.$mysqli->error;
			}
		}
	}
	
	function SendCharmsToRelative($parentID, $Charms, $ownEmail){
		include_once '../config/Config.php';
		$conn = new DatabaseConnect();
		$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);
		
		$query = "UPDATE users
				SET charms = 
				WHERE Username = '".$user."'
				";
		if(!$result=$mysqli->query($query)){
			die("N/A: Database Error:".$mysqli->error."");
		}
		while($row = $result->fetch_assoc()){
			echo $row['Charms'];
		}
		
	}
	

		
}



$obj = new Parents();
//$obj->SendForgotPasswordEmail('dfsffsdsd@hotmail.co.uk');
//$obj -> UpdateParentAccount('hi','hi','no','no','alex_kell@hotmail.co.uk','hi','F','Mr')
//$obj->LoginParent('alex_kell@hotmail.co.uk','hi')
//$obj->UpdateParentAccountOther('alex_kell@hotmail.co.uk','2','3','4')
//$obj->GetCurrencies('alex')
?>