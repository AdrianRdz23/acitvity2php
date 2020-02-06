<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Services\Business\SecurityService;

class LoginController extends Controller{
    
    // BEST PRACITCE: name your methods properly and clearly (index()
    // is pretty bad for a Controller form POST
    public function index(Request $request){
        
        //Get the posted Form Data
        $username = $request->input('username');
        $password = $request->input('password');
        
        //Save posted Form Data in User Object Model
        $user = new UserModel(-1, $username, $password);
        
        //Call Security Business Service
        //BEST PRACTICE : pass course grained not fine frained parameters
        $service = new SecurityService();
        $status = $service->login($user);
        
        //Render a failed or success response View and pass the User Model to it 
        if($status){
            $data = ['model' => $user];
            return view('loginPassed')->with($data);
        }
        else{
            return view('loginFailed');
        }
        

    }}
