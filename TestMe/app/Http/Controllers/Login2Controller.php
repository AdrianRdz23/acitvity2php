<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Services\Business\SecurityService;

class Login2Controller extends Controller{
    
    // BEST PRACITCE: name your methods properly and clearly (index()
    // is pretty bad for a Controller form POST
    public function index(Request $request){
        try{
            //BEST PRACTICE: centralize your rules so you have a consistent architecture and even reuse your rules
            $this->validateForm($request);
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
            return view('loginPassed2')->with($data);
        }
        else{
            return view('loginFailed2');
        }
        }
        catch(ValidationException $e1){
            $this->validateForm($request);
        }
        catch(Exception $e2)
        {
            return view('loginFailed2');
        }
        
    }}
    