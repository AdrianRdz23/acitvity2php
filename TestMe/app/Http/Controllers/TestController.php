<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    
 
    public function test(){
        return "Hello World From My Test Controller";
    }
    
    
    public function test2(){
        return "Hello World From My Test Controller this a second test";
    }
    
    
    
}


