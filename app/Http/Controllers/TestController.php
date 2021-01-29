<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function print_test_data()
	{
        $json = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/users"));

        foreach ($json as $person) {
            print_r($person->address->city);
        }
	}
}
