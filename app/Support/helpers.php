<?php

// App
use App\User;

if(!function_exists('randomDate')) {
    /**
	* Generate random date
	*
	* @return \App\User
	*/
    function randomDate()
    {
        $int = mt_rand(1580282056, 1611904456);
        return date("Y-m-d H:i:s", $int);
    }
}