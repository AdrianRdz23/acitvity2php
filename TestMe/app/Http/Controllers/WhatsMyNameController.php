<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class WhatsMyNameController extends Controller
{
    public function index(Request $request){
        //Display the Form Data
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        echo "Your name is: " . $firstName . "  " . $lastName;
        echo '<br>';
        
        //Render a response View and pass the Form Data to it
        $data = ['firstName' => $firstName, 'lastName' => $lastName];
        return view('thatswhoiam')->with($data);
    }
}

