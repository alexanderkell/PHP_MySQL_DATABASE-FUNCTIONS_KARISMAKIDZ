
<?php 
include_once '../functions/Parents.php';
include_once '../functions/DatabaseConnect.php';
$conn = new DatabaseConnect();

include '../config/Config.php';

$mysqli=$conn->connect($db_host, $db_username, $db_password, $mysql_db);



//if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
	// Verify data
	//$email = mysql_escape_string($_GET['email']); // Set email variable
	//$hash = mysql_escape_string($_GET['hash']); // Set hash variable
	$updatePass = md5(mysql_escape_string($_POST["password"]));

	$email = 'dfsffsdsd@hotmail.co.uk';
	$hash = '4ef30115b941a1bcd71ffebb50c69ece';
	$query = "SELECT password FROM parents WHERE email='".$email."' AND hash='".$hash."' ";
	
	if(!$search = $mysqli -> query($query)){
		echo 'Could not update password: ' .mysqli_error($mysqli);
	}else{
		$match  = mysqli_num_rows($search);
		if($match > 0){
			$update = "UPDATE parents SET password = '".$updatePass."' 
			WHERE email ='".$email."' 
			AND hash='".$hash."'";
			$mysqli->query($update);
			echo 'Thank you, your new password has been saved.';
		}else{
			echo 'Could not find account. Please copy and paste link from email in your browser.';
		}
			
	}
	mysqli_close($conn)
?>