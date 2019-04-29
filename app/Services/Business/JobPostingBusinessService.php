<?php
//Milestone 5
//Emily Quevedo
//March 10, 2019
//This is my own work

/*Handles job posting business logic and connections to database*/
namespace App\Services\Business;

use Illuminate\Support\Facades\Log;
use PDO;
use App\Services\Data\JobPostDataService;

class JobPostingBusinessService {

    /**
     * Finds the job post by name
     * @param $jobPost
     * @return array
     */
    public function findJobByName($jobPost) {
        Log::info("Entering JobPostingBusinessService.findJobByName()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find the job posting by name
        $service = new JobPostDataService($conn);
        $flag = $service->findJobByName($jobPost);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.findJobPostingByID() with " . print_r($flag, true));
        return $flag;
    }
}