<?php
class Config{
	public static function get($path=null){ //function which takes the path and calls it from init
		if($path){
			$config = $GLOBALS['config'];//enter this array
			$path = explode('/', $path);
			
			foreach($path as $bit){
				if(isset($config[$bit])){
					$config = $config[$bit];
				}
			}
			return $config;
		}
		return false;
	}
}