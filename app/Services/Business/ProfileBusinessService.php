<?php
//Emily Quevedo
//CST 256
//February 20, 2019
//This is my own work
/*Handles user profile business logic and connections to database*/
namespace App\Services\Business;

use \PDO;
use Illuminate\Support\Facades\Log;
use App\Models\ContactModel;
use App\Services\Data\ProfileDataService;
use App\Models\EducationModel;
use App\Models\JobHistoryModel;
use App\Models\SkillsModel;
use App\Models\UserGroupModel;
use App\Models\UserJobModel;

class ProfileBusinessService {
 
    /**
     * Creates the user's contact info
     * @param ContactModel $contactInfo
     * @return boolean
     */
    public function addContactInfo(ContactModel $contactInfo) {
        Log::info("Entering ProfileBusinessService.addContactInfo()");
    
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and create user contact info
        $service = new ProfileDataService($conn);
        $flag = $service->createContactInfo($contactInfo);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.addContactInfo() with " . $flag);
        return $flag;
    }
    
    /**
     * Finds the contact info by id
     * @param $id
     * @return array
     */
    public function findContactByID($id) {
        Log::info("Entering ProfileBusinessService.findContactByID()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find contact info by id
        $service = new ProfileDataService($conn);
        $flag = $service->findContactByID($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.findContactByID() with " . print_r($flag, true));
        return $flag;
    }
    
    /**
     * Updates the contact info
     * @param ContactModel $contactInfo
     * @return boolean
     */
    public function editContactInfo(ContactModel $contactInfo)
    {
        Log::info("Entering ProfileBusinessService.editContactInfo()");
        // get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        // create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // create a profile dao with this connection and try to update user contact info
        $service = new ProfileDataService($conn);
        $flag = $service->updateContactInfo($contactInfo);
        // return the finder results
        Log::info("Exit ProfileBusinessService.editContactInfo() with " . $flag);
        return $flag;
    }
    
    /**
     * Deletes the user's contact info
     * @param $id
     * @return boolean
     */
    public function removeContactInfo($id) {
        Log::info("Entering ProfileBusinessService.removeContactInfo()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find and delete user contact info
        $service = new ProfileDataService($conn);
        $flag = $service->deleteContact($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.removeContactInfo() with " . $flag);
        return $flag;
    }
    
    /**
     * Creates the user's education
     * @param EducationModel $education
     * @return boolean
     */
    public function addEducation(EducationModel $education) {
        Log::info("Entering ProfileBusinessService.addEducation()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a security service dao with this connection and create user education
        $service = new ProfileDataService($conn);
        $flag = $service->createEducation($education);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.addEducation() with " . $flag);
        return $flag;
    }
    
    /**
     * Finds the user's education by id
     * @param $id
     * @return array
     */
    public function findEducationByID($id) {
        Log::info("Entering ProfileBusinessService.findEducationByID()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find the password in user
        $service = new ProfileDataService($conn);
        $flag = $service->findEducationByID($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.findEducationByID() with " . print_r($flag, true));
        return $flag;
    }
    
    /**
     * Updates the user's education info
     * @param EducationModel $education
     * @return boolean
     */
    public function editEducation(EducationModel $education) {
        Log::info("Entering ProfileBusinessService.editEducation()");
        
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
        
        //create a profile dao with this connection and try to find and update education
        $service = new ProfileDataService($conn);
        $flag = $service->updateEducation($education);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.editEducation() with " . $flag);
        return $flag;
    }
    
    /**
     * Deletes the user's education
     * @param $id
     * @return boolean
     */
    public function removeEducation($id) {
        Log::info("Entering ProfileBusinessService.removeEducation()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find and delete education
        $service = new ProfileDataService($conn);
        $flag = $service->deleteEducation($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.removeEducation() with " . $flag);
        return $flag;
    }
   
    /**
     * Creates the user's job history
     * @param JobHistoryModel $history
     * @return boolean
     */
    public function addJobHistory(JobHistoryModel $history) {
        Log::info("Entering ProfileBusinessService.addJobHistory()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and create user job history
        $service = new ProfileDataService($conn);
        $flag = $service->createJobHistory($history);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.addJobHistory() with " . $flag);
        return $flag;
    }
    
    /**
     * Finds the user's job history by id
     * @param $id
     * @return array
     */
    public function findJobHistoryByID($id) {
        Log::info("Entering ProfileBusinessService.findJobHistoryByID()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find the job history by id
        $service = new ProfileDataService($conn);
        $flag = $service->findJobHistoryByID($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.findJobHistoryByID() with " . print_r($flag, true));
        return $flag;
    }
    
    /**
     * Updates the user's job history info
     * @param JobHistoryModel $history
     * @return boolean
     */
    public function editJobHistory(JobHistoryModel $history) {
        Log::info("Entering ProfileBusinessService.editJobHistory()");
        
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
        
        //create a profile dao with this connection and try to find and update education
        $service = new ProfileDataService($conn);
        $flag = $service->updateJobHistory($history);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.editJobHistory() with " . $flag);
        return $flag;
    }
    
    /**
     * Deletes the job history
     * @param  $id
     * @return boolean
     */
    public function removeJobHistory($id) {
        Log::info("Entering ProfileBusinessService.removeJobHistory()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find and delete skill
        $service = new ProfileDataService($conn);
        $flag = $service->deleteJobHistory($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.removeJobHistory() with " . $flag);
        return $flag;
    }
    
    /**
     * Creates user skills
     * @param SkillsModel $skills
     * @return boolean
     */
    public function addSkills(SkillsModel $skills) {
        Log::info("Entering ProfileBusinessService.addSkills()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile with this connection and create user skills
        $service = new ProfileDataService($conn);
        $flag = $service->createSkills($skills);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.addSkills() with " . $flag);
        return $flag;
    }
    
    /**
     * Finds user skills by id
     * @param $id
     * @return array
     */
    public function findSkillsByID($id) {
        Log::info("Entering ProfileBusinessService.findSkillsByID()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find the password in user
        $service = new ProfileDataService($conn);
        $flag = $service->findSkillsByID($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.findSkillsByID() with " . print_r($flag, true));
        return $flag;
    }
    
    /**
     * Updates user skill info
     * @param SkillsModel $skill
     * @return boolean
     */
    public function editSkills(SkillsModel $skill) {
        Log::info("Entering ProfileBusinessService.editSkills()");
        
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
        
        //create a profile dao with this connection and try to find and update education
        $service = new ProfileDataService($conn);
        $flag = $service->updateSkills($skill);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.editSkills() with " . $flag);
        return $flag;
    }
    
    /**
     * Deletes skill
     * @param $id
     * @return boolean
     */
    public function removeSkill($id) {
        Log::info("Entering ProfileBusinessService.removeSkill()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find and delete skill
        $service = new ProfileDataService($conn);
        $flag = $service->deleteSkill($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.removeSkill() with " . $flag);
        return $flag;
    }
    
    /**
     * Finds members of group by id
     * @param $id
     * @return array
     */
    public function findGroupMemberByID($id) {
        Log::info("Entering ProfileBusinessService.findGroupMemberByID()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find the password in user
        $service = new ProfileDataService($conn);
        $flag = $service->findGroupMember($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.findGroupMemberByID() with " . print_r($flag, true));
        return $flag;
    }
    
    /**
     * Allows user to join a group
     * @param UserGroupModel $userGroup
     * @return boolean
     */
    public function addUserGroup(UserGroupModel $userGroup) {
        Log::info("Entering ProfileBusinessService.addUserGroup()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and create user contact info
        $service = new ProfileDataService($conn);
        $flag = $service->createUserGroup($userGroup);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.addUserGroup() with " . $flag);
        return $flag;
    }
    
    /**
     * Removes user from the group
     * @param $id
     * @return boolean
     */
    public function removeUserFromGroup($id) {
        Log::info("Entering ProfileBusinessService.removeUserFromGroup()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection to database
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and try to find and delete skill
        $service = new ProfileDataService($conn);
        $flag = $service->deleteUserGroup($id);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.removeUserFromGroup() with " . $flag);
        return $flag;
    }
    
    /**
     * Allows user to apply to a job 
     * @param UserJobModel $userJob
     * @return boolean
     */
    public function addUserJob(UserJobModel $userJob) {
        Log::info("Entering ProfileBusinessService.addUserJob()");
        
        //get credentials for accessing the database
        $servername = config("database.connections.mysql.host");
        $dbname = config("database.connections.mysql.database");
        $username = config("database.connections.mysql.username");
        $password = config("database.connections.mysql.password");
        
        //create connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //create a profile dao with this connection and create user contact info
        $service = new ProfileDataService($conn);
        $flag = $service->createUserJob($userJob);
        
        //return the finder results
        Log::info("Exit ProfileBusinessService.addUserJob() with " . $flag);
        return $flag;
    }
}