<?php
//Emily Quevedo
//CST 256
//February 20, 2019
//This is my own work

//Database interacts with the data from Admin class
namespace App\Services\Data;

use Illuminate\Support\Facades\Log;
use App\Models\JobModel;
use App\Services\Utility\DatabaseException;
use PDO;
use PDOException;
use App\Models\AffinityGroupModel;


class AdminDataService {
    private $conn = null;
    
    //best practice: do not create a database connections in a dao
    //so you can support atomic database transactions
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Fetches all users from the database
     * @throws DatabaseException
     * @return array
     */
    public function findAllUsers() {
        Log::info("Entering AdminDataService.findAllUsers()");
        
        try {
            //prepared statement is created to display users
            $stmt = $this->conn->prepare('SELECT * from users');
            //executes prepared query
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                //user array is created
                $userArray = array();
                //fetches result from prepared statement and returns as an array
                while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //inserts variables into end of array
                    array_push($userArray, $user);
                }
                
                Log::info("Exit AdminDataService.findAllUsers() with true");
                //return user array
                return $userArray;
            }
        }
        
        catch (PDOException $e) {
            //best practice: catch all exceptions (do not swallow exceptions),
            //log the exception, do not throw technology specific exceptions,
            //and throw a custom exception
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Deletes the user from the database
     * @param  $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteUser($id) {
        Log::info("Entering AdminDataService.deleteUser()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM users WHERE `ID` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if user has been deleted from database
            if ($delete) {
                Log::info("Exiting AdminDataService.deleteUser() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting AdminDataService.deleteUser() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Suspends the user's account
     * @param  $id
     * @throws DatabaseException
     * @return boolean
     */
    public function suspendUser($id) {
        Log::info("Entering AdminDataService.suspendUser()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare("UPDATE users SET `ACTIVE` = '1' WHERE `ID` = :id");
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $suspend = $stmt->execute();
            
            //returns true or false if user active row has been set to 1
            if ($suspend) {
                Log::info("Exiting AdminDataService.suspendUser() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting AdminDataService.suspendUser() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Unsuspends the user's account
     * @param  $id
     * @throws DatabaseException
     * @return boolean
     */
    public function unsuspendUser($id) {
        Log::info("Entering AdminDataService.unsuspendUser()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare("UPDATE users SET `ACTIVE` = '0' WHERE `ID` = :id");
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $suspend = $stmt->execute();
            
            //returns true or false if user active row has been set to 0
            if ($suspend) {
                Log::info("Exiting AdminDataService.unsuspendUser() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting AdminDataService.unsuspendUser() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Creates a new job post
     * @param JobModel $job
     * @throws DatabaseException
     * @return boolean
     */
    public function createNewJobPosting(JobModel $job) {
        Log::info("Entering AdminDataService.createNewJobPosting()");
        
        try {
            //select variables and see if the row exists
            $title = $job->getJobTitle();
            $position = $job->getPosition();
            $description = $job->getDescription();
            $employerName = $job->getCompanyName();
            $city = $job->getCity();
            $state = $job->getState();
            $datePosted = $job->getDatePosted();
            
            
            //prepared statements is created
            $stmt = $this->conn->prepare("INSERT INTO `job_posting` (`JOBTITLE`, `POSITION`, `DESCRIPTION`, `EMPLOYER`, `CITY`, `STATE`, `DATE`) VALUES (:title, :position, :description, :employer, :city, :state, :date)");
            //binds parameters
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':employer', $employerName);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':date', $datePosted);
            
            /*see if job posting was created and return true 
             else return false if failed*/
            if ($stmt->execute()) {
                Log::info("Exit AdminDataService.createNewJobPosting() with true");
                return true;
            }
            
            else {
                Log::info("Exit UserDataService.createNewJobPosting() with false");
                return false;
            }
        }
        
        catch (PDOException $e) {
            //best practice: catch all exceptions (do not swallow exceptions),
            //log the exception, do not throw technology specific exceptions,
            //and throw a custom exception
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Finds all job posts from the database
     * @throws DatabaseException
     * @return array
     */
    public function findAllJobs() {
        Log::info("Entering AdminDataService.findAllJobs()");
        
        try {
            //prepared statement is created to display jobs
            $stmt = $this->conn->prepare('SELECT * from job_posting');
            //executes prepared query
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                //job array is created
                $jobArray = array();
                //fetches result from prepared statement and returns as an array
                while ($job = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //inserts variables into end of array
                    array_push($jobArray, $job);
                }
                
                Log::info("Exit AdminDataService.findAllJobs() with true");
                //return job array
                return $jobArray;
            }
        }
        
        catch (PDOException $e) {
            //best practice: catch all exceptions (do not swallow exceptions),
            //log the exception, do not throw technology specific exceptions,
            //and throw a custom exception
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Deletes the job post from the database
     * @param  $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteJob($id) {
        Log::info("Entering AdminDataService.deleteJob()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM job_posting WHERE `ID` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if job posting has been deleted from database
            if ($delete) {
                Log::info("Exiting AdminDataService.deleteJob() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting AdminDataService.deleteJob() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Finds the job post by id
     * @param  $id
     * @throws DatabaseException
     * @return array
     */
    public function findJobPostingByID($id) {
        Log::info("Entering AdminDataService.findJobPostingByID()");
        
        try {
            $stmt = $this->conn->prepare('SELECT * FROM job_posting WHERE ID = :id');
            $stmt->bindParam(':id', $id);
            
            //list array is created and statement is executed
            $list = array();
            $stmt->execute();
                       
            //loops through table  using stmt->fetch         
            for ($i = 0; $row = $stmt->fetch(); $i++) {
                //job model is created 
                $job = new JobModel($id, $row['JOBTITLE'], $row['POSITION'], $row['DESCRIPTION'], $row['EMPLOYER'], $row['CITY'], $row['STATE'], $row['DATE']);
                //inserts variables into end of array
                array_push($list, $job);
            }
            //return list array that holds job variables
            Log::info("Exit AdminDataService.findJobPostingByID() with true");
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
    
    /**
     * Updates the job post info in database
     * @param JobModel $jobPosting
     * @throws DatabaseException
     * @return boolean
     */
    public function updateJobPosting(JobModel $jobPosting)
    {
        Log::info("Entering AdminDataService.updateJobPosting()");
        try {
            // select variables and see if the row exists
            $id = $jobPosting->getId();
            $title = $jobPosting->getJobTitle();
            $position = $jobPosting->getPosition();
            $description = $jobPosting->getDescription();
            $company = $jobPosting->getCompanyName();
            $city = $jobPosting->getCity();
            $state = $jobPosting->getState();
            $date = $jobPosting->getDatePosted();
            
            // prepared statements is created
            $stmt = $this->conn->prepare("UPDATE job_posting SET JOBTITLE = :title, POSITION = :position, DESCRIPTION = :description, EMPLOYER = :company, CITY = :city, STATE = :state, DATE = :date WHERE ID = :id");
            // binds parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':position', $position);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':company', $company);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':date', $date);
            
            $stmt->execute();
            /*
             * see if new job posting data was inserted
             * else return false
             */
            if ($stmt->rowCount() == 1) {
                Log::info("Exit AdminDataService.updateJobPosting() with true");
                return true;
            } else {
                Log::info("Exit AdminDataService.updateJobPosting() with false");
                return false;
            }
        } catch (PDOException $e) {
            // best practice: catch all exceptions (do not swallow exceptions),
            // log the exception, do not throw technology specific exceptions,
            // and throw a custom exception
            Log::error("Exception: ", array(
                "message" => $e->getMessage()
            ));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Creates a new affinity group 
     * @param AffinityGroupModel $group
     * @throws DatabaseException
     * @return boolean
     */
    public function createGroup(AffinityGroupModel $group) {
        Log::info("Entering AdminDataService.createGroup()");
        
        try {
            //select variables and see if the row exists
            $name = $group->getGroupName();
            $description = $group->getGroupDescription();         
            
            //prepared statements is created
            $stmt = $this->conn->prepare("INSERT INTO `groups` (`NAME`, `DESCRIPTION`) VALUES (:name, :description)");
            //binds parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            
            /*see if the group was created and return true
             else return false if failed*/
            if ($stmt->execute()) {
                Log::info("Exit AdminDataService.createNewGroup() with true");
                return true;
            }
            
            else {
                Log::info("Exit UserDataService.createNewGroup() with false");
                return false;
            }
        }
        
        catch (PDOException $e) {
            //best practice: catch all exceptions (do not swallow exceptions),
            //log the exception, do not throw technology specific exceptions,
            //and throw a custom exception
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Finds the group by id
     * @param  $id
     * @throws DatabaseException
     * @return array
     */
    public function findGroupByID($id) {
        Log::info("Entering AdminDataService.findGroupByID()");
        
        try {
            $stmt = $this->conn->prepare('SELECT * FROM groups WHERE ID = :id');
            $stmt->bindParam(':id', $id);
            
            //list array is created and statement is executed
            $list = array();
            $stmt->execute();
            
            //loops through table  using stmt->fetch
            for ($i = 0; $row = $stmt->fetch(); $i++) {
                //group model is created
                $group = new AffinityGroupModel($id, $row['NAME'], $row['DESCRIPTION']);
                //inserts variables into end of array
                array_push($list, $group);
            }
            //return list array that holds group variables
            Log::info("Exit AdminDataService.findGroupByID() with true");
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
    
    /**
     * Finds all groups from the database
     * @throws DatabaseException
     * @return array
     */
    public function findAllGroups() {
        Log::info("Entering AdminDataService.findAllGroups()");
        
        try {
            //prepared statement is created to display groups
            $stmt = $this->conn->prepare('SELECT * from groups');
            //executes prepared query
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                //group array is created
                $groupArray = array();
                //fetches result from prepared statement and returns as an array
                while ($job = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //inserts variables into end of array
                    array_push($groupArray, $job);
                }
                
                Log::info("Exit AdminDataService.findAllGroups() with true");
                //return group array
                return $groupArray;
            }
        }
        
        catch (PDOException $e) {
            //best practice: catch all exceptions (do not swallow exceptions),
            //log the exception, do not throw technology specific exceptions,
            //and throw a custom exception
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Updates group info in database
     * @param AffinityGroupModel $group
     * @throws DatabaseException
     * @return boolean
     */
    public function updateGroup(AffinityGroupModel $group)
    {
        Log::info("Entering AdminDataService.updateGroup()");
        try {
            // select variables and see if the row exists
            $id = $group->getId();
            $name = $group->getGroupName();
            $description = $group->getGroupDescription();
            
            // prepared statements is created
            $stmt = $this->conn->prepare("UPDATE groups SET NAME = :name, DESCRIPTION = :description WHERE ID = :id");
            // binds parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);

            
            $stmt->execute();
            /*
             * see if new job posting data was inserted
             * else return false
             */
            if ($stmt->rowCount() == 1) {
                Log::info("Exit AdminDataService.updateGroup() with true");
                return true;
            } else {
                Log::info("Exit AdminDataService.updateGroup() with false");
                return false;
            }
        } catch (PDOException $e) {
            // best practice: catch all exceptions (do not swallow exceptions),
            // log the exception, do not throw technology specific exceptions,
            // and throw a custom exception
            Log::error("Exception: ", array(
                "message" => $e->getMessage()
            ));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Deletes the group from database
     * @param $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteGroup($id) {
        Log::info("Entering AdminDataService.deleteGroup()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM groups WHERE `ID` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if job posting has been deleted from database
            if ($delete) {
                Log::info("Exiting AdminDataService.deleteGroup() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting AdminDataService.deleteGroup() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
}