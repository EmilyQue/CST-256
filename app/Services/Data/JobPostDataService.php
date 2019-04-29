<?php
//Emily Quevedo
//CST 256
//March 10, 2019
//This is my own work

//Database interacts with the data from Job Post class
namespace App\Services\Data;

use Illuminate\Support\Facades\Log;
use App\Services\Utility\DatabaseException;
use PDOException;
use App\Models\JobModel;

class JobPostDataService {
    private $conn = null;
    
    //best practice: do not create a database connections in a dao
    //so you can support atomic database transactions
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Finds the job post by name
     * @param  $jobName
     * @throws DatabaseException
     * @return array
     */
    public function findJobByName($jobName) {
            Log::info("Entering ProfileDataService.findContactByID()");
            try {

                //prepared statement is created and user id is binded
                $stmt = $this->conn->prepare("SELECT ID, JOBTITLE, POSITION, DESCRIPTION, EMPLOYER, CITY, STATE, DATE FROM job_posting WHERE JOBTITLE LIKE '%".$jobName."%' OR DESCRIPTION LIKE '%".$jobName."%' ");
                
                //array is created and statement is executed
                $list = array();
                $stmt->execute();
                
                //loops through table  using stmt->fetch
                for ($i = 0; $row = $stmt->fetch(); $i++) {
                    //contact model is created
                    $jobSearch = new JobModel($row['ID'], $row['JOBTITLE'], $row['POSITION'], $row['DESCRIPTION'], $row['EMPLOYER'], $row['CITY'], $row['STATE'], $row['DATE']);
                    //inserts variables into end of array
                    array_push($list, $jobSearch);
                }
                //return list array that holds contact variables
                Log::info("Exit ProfileDataService.findContactByID() with true");
                return $list;
            }
            
            catch (PDOException $e) {
                //best practice: catch all exceptions (do not swallow exceptions),
                //log the exception, do not throw technology specific exceptions,
                //and throw a custom exception
                Log::error("Exception: ", array("message" => $e->getMessage()));
                throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
            }
        }
}