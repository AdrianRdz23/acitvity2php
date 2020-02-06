<?php
namespace App\Services\Business;

use PDO;
use App\Services\Data\SecurityDAO;
use App\Models\UserModel;
use Illuminate\Support\Facades\Log;



class SecurityService{
    public function login(UserModel $user){
        
        Log::info("Entering SecurityService.login()");
        
        // BEST PRACTICE : Externalize your application configuration
        // Get credentials for accessing the database
        // REFATCOR: The initialization code is repeated in all the business methods
        
        $servername = config("database.connections.mysql.host");
        $port = config("database.connections.mysql.port");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        $dbname = config("database.connections.mysql.databse");
        
        //BEST_PRACTICE: Do not create Dtabase Connections in a DAO
        //___(so you can support Atomic Database Transactions)
        //Create connection
        $db= new PDO("mysql:host=$servername;port=$port;dbname=$dbname",$username,$password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create a Security Service DAO with this connection and try to find the password in User
        $service= new SecurityDAO($db);
        $flag = $service->findByUser($user);
        
        $db = null;
        
        //Return the finder results
        Log::info("Exit SecurityService.login() with " . $flag);
        return $flag;
    }
}