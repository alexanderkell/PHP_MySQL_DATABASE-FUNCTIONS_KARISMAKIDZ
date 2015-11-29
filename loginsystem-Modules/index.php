<?php
require_once 'init.php';

echo Config::get('mysql/host');

$users = DB::getInstance()->get('SELECT username FROM parents');
if($users->count()){
	foreach($users as $user){
		echo $user->username;
	}
}

?>