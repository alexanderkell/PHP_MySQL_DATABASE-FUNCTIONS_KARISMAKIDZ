<?php
//make more secure when input and output

function escape($string){
	return htmlentities($string, ENT_QUOTES, 'UTF-8'); //relatively secure
}