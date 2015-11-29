<?php
//Work with database

class DB{
	private static $_instance = null; //private static property which stores instance
	private $_pdo, 
			$_query, 
			$_error=false,
			$_results,
			$_count = 0;
}



?>