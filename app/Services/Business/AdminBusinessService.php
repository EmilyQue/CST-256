<?php
//Milestone 3
//Emily Quevedo
//February 20, 2019
//This is my own work

/*Handles admin business logic and connections to database*/
namespace App\Services\Business;

use Illuminate\Support\Facades\Log;
use PDO;
use App\Services\Data\AdminDataService;
use App\Models\JobModel;
use App\Models\AffinityGroupModel;

class AdminBusinessService {
    
    /**
     * Deletes user
     * @param $id
     * @return boolean
     */
    public function removeUser($id) {
        Log::info("Entering AdminBusinessService.removeUser()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find and delete user
        $service = new AdminDataService($conn);
        $flag = $service->deleteUser($id);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.removeUser() with " . $flag);
        return $flag;
    }
    
    /**
     * Suspend user
     * @param $id
     * @return boolean
     */
    public function suspendUser($id) {
        Log::info("Entering AdminBusinessService.suspendUser()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find and suspend user
        $service = new AdminDataService($conn);
        $flag = $service->suspendUser($id);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.suspendUser() with " . $flag);
        return $flag;
    }
    
    /**
     * Unsuspends user
     * @param $id
     * @return boolean
     */
    public function unsuspendUser($id) {
        Log::info("Entering AdminBusinessService.unsuspendUser()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find and unsuspend user
        $service = new AdminDataService($conn);
        $flag = $service->unsuspendUser($id);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.unsuspendUser() with " . $flag);
        return $flag;
    }
    
    /**
     * Displays all users
     * @return array
     */
    public function showUsers() {
        Log::info("Entering AdminBusinessService.showUsers()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //best practice: do not create database connections in a dao
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to display all users
        $service = new AdminDataService($conn);
        //calls the findAllUsers command
        $flag = $service->findAllUsers();
        //return the finder results
        return $flag;
        
        Log::info("Exit AdminBusinessService.showUsers() with " . $flag);
    }
    
    /**
     * Creates a new job post
     * @param JobModel $job
     * @return boolean
     */
    public function addJobPosting(JobModel $job) {
        Log::info("Entering AdminBusinessService.addJobPosting()");
        
        //best practice: externalize your app configuration
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //best practice: do not create database connections in a dao
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and create a new job posting
        $service = new AdminDataService($conn);
        $flag = $service->createNewJobPosting($job);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.addJobPosting() with " . $flag);
        return $flag;
    }
    
    /**
     * Displays all job posts
     * @return array
     */
    public function showJobs() {
        Log::info("Entering AdminBusinessService.showJobs()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //best practice: do not create database connections in a dao
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find jobs and display them
        $service = new AdminDataService($conn);
        //calls the findAllJobs command
        $flag = $service->findAllJobs();
        //return the finder results
        return $flag;
        
        Log::info("Exit AdminBusinessService.showJobs() with " . $flag);
    }
    
    /**
     * Deletes job post
     * @param $id
     * @return boolean
     */
    public function removeJob($id) {
        Log::info("Entering AdminBusinessService.removeJob()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find and delete job posting
        $service = new AdminDataService($conn);
        $flag = $service->deleteJob($id);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.removeJob() with " . $flag);
        return $flag;
    }

    /**
     * Finds job post by id
     * @param $id
     * @return array
     */
    public function findJobPostingByID($id) {
        Log::info("Entering AdminBusinessService.findJobPostingByID()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find the job posting by id
        $service = new AdminDataService($conn);
        $flag = $service->findJobPostingByID($id);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.findJobPostingByID() with " . print_r($flag, true));
        return $flag;
    }
    
    /**
     * Updates the job post info
     * @param JobModel $job
     * @return boolean
     */
    public function editJobPosting(JobModel $job) {
        Log::info("Entering AdminBusinessService.editJobPosting()");
        
        //best practice: externalize your app configuration
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //best practice: do not create database connections in a dao
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and update job posting
        $service = new AdminDataService($conn);
        $flag = $service->updateJobPosting($job);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.editJobPosting() with " . $flag);
        return $flag;
    }

    /**
     * Creates an affinity group
     * @param AffinityGroupModel $group
     * @return boolean
     */
    public function addGroup(AffinityGroupModel $group) {
        Log::info("Entering AdminBusinessService.addGroup()");
        
        //best practice: externalize your app configuration
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //best practice: do not create database connections in a dao
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and create a new affinity group
        $service = new AdminDataService($conn);
        $flag = $service->createGroup($group);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.addGroup() with " . $flag);
        return $flag;
    }
    
    /**
     * Displays all groups
     * @return array
     */
    public function showGroups() {
        Log::info("Entering AdminBusinessService.showGroups()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //best practice: do not create database connections in a dao
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find jobs and display them
        $service = new AdminDataService($conn);
        //calls the findAllJobs command
        $flag = $service->findAllGroups();
        //return the finder results
        return $flag;
        
        Log::info("Exit AdminBusinessService.showGroups() with " . $flag);
    }
    
    /**
     * Finds a group by id
     * @param $id
     * @return array
     */
    public function findGroupByID($id) {
        Log::info("Entering AdminBusinessService.findGroupByID()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find the job posting by id
        $service = new AdminDataService($conn);
        $flag = $service->findGroupByID($id);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.findJobPostingByID() with " . print_r($flag, true));
        return $flag;
    }
    
    /**
     * Updates the group info
     * @param AffinityGroupModel $group
     * @return boolean
     */
    public function editGroup(AffinityGroupModel $group) {
        Log::info("Entering AdminBusinessService.editGroup()");
        
        //best practice: externalize your app configuration
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //best practice: do not create database connections in a dao
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and update job posting
        $service = new AdminDataService($conn);
        $flag = $service->updateGroup($group);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.editGroup() with " . $flag);
        return $flag;
    }
    
    /**
     * Deletes the group 
     * @param $id
     * @return boolean
     */
    public function removeGroup($id) {
        Log::info("Entering AdminBusinessService.removeGroup()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create an admin dao with this connection and try to find and delete job posting
        $service = new AdminDataService($conn);
        $flag = $service->deleteGroup($id);
        
        //return the finder results
        Log::info("Exit AdminBusinessService.removeGroup() with " . $flag);
        return $flag;
    }
}