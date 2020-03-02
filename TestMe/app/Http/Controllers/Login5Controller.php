<?php
namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Services\Business\SecurityService;
use Dotenv\Exception\ValidationException;
use App\Services\Utility\MyLogger1;
use App\Services\Utility\MyLogger2;

class Login5Controller extends Controller{
    
    // BEST PRACITCE: name your methods properly and clearly (index()
    // is pretty bad for a Controller form POST
    public function index(Request $request){
        
        Log::info("Entering Login5Controller.index()");
        try{
            //BEST PRACTICE: centralize your rules so you have a consistent architecture and even reuse your rules
            $this->validateForm($request);
            
            //Get the posted Form Data
            $username = $request->input('username');
            $password = $request->input('password');
            Log::info("Parameters:", array("username" =>$username, "password"=>$password));
            
            //Save posted Form Data in User Object Model
            $user = new UserModel(-1, $username, $password);
            
            //Call Security Business Service
            //BEST PRACTICE : pass course grained not fine frained parameters
            $service = new SecurityService();
            $status = $service->login($user);
            
            //Render a failed or success response View and pass the User Model to it
            if($status){
                MyLogger2::info("Exit Login5Controller.index() with login passed");
                $data = ['model' => $user];
                return view('loginPassed5')->with($data);
            }
            else{
                MyLogger2::info("Exit Login5Controller.index() with login failed)");
                return view('loginFailed5');
            }
            
        }
        catch(ValidationException $e1){
            $this->validateForm($request);
            
            throw $e1;
        }
        catch(Exception $e2)
        {
            MyLogger1::info("Exception: ", array("message" => $e2->getMessage()));
            
            return view('systemException');
        }
        
    }
    
    private function validateForm(Request $request){
        
        //BEST PRACTICE: centralize your urles so you have a consistent architecture
        //and even reuse tour rules
        //BAD PRACTICE: not using a defined Data Validation Framework, putting rules
        //all over your code, doing only on Client Side or Database
        //Setup Data Validation Rules for LoginForm
        $rules =['username' => 'Required | Between:4,10 | Alpha ',
            'password' => 'Required | Between:4,10'];
        
        //Run Data Validation Rules
        $this->validate($request, $rules);
    }}