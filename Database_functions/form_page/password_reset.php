<?php 
if(isset($_POST['password2'])){
	$updatePass = md5(mysql_escape_string($_POST["password"]));
	$retypePass = md5(mysql_escape_string($_POST["password2"]));
	if($updatePass==$retypePass){
		header( 'Location: pass_reset_action.php' ) ;
		exit;
	}else{
		echo 'Passwords do not match, try again';
	}
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Email Verification</title>	
</head>
<body>
Please enter your new password <br><br>
<form action ="password_reset.php" method="post">
	Password: <input type="password" name="password"><br>
	Retype password <input type="password" name="password2"><br>
	<input type="submit">
</form>


</body>


