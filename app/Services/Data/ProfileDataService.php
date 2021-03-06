<?php
//Emily Quevedo
//CST 256
//February 20, 2019
//This is my own work

//Database interacts with the data from Profile class
namespace App\Services\Data;

use Illuminate\Support\Facades\Log;
use App\Models\ContactModel;
use App\Services\Utility\DatabaseException;
use PDOException;
use App\Models\EducationModel;
use App\Models\JobHistoryModel;
use App\Models\SkillsModel;
use App\Models\UserGroupModel;
use App\Models\UserJobModel;

class ProfileDataService {
    private $conn = null;
    
    //best practice: do not create a database connections in a dao
    //so you can support atomic database transactions
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Creates user contact info
     * @param ContactModel $contactInfo
     * @throws DatabaseException
     * @return boolean
     */
    public function createContactInfo(ContactModel $contactInfo) {
        Log::info("Entering ProfileDataService.createContactInfo()");
        
        try {
            //select variables and see if row exists
            $businessEmail = $contactInfo->getBusinessEmail();
            $phoneNumber = $contactInfo->getPhone();
            $aboutMe = $contactInfo->getAboutMe();
            $streetAddress = $contactInfo->getStreetAddress();
            $city = $contactInfo->getCity();
            $state = $contactInfo->getState();
            $zipcode = $contactInfo->getZipcode();
            $user_id = $contactInfo->getUser_id();
            
            //prepared statement is created
            $stmt = $this->conn->prepare("INSERT INTO `contact` (`BUSINESS_EMAIL`, `PHONE`, `ABOUT`, `STREET`, `CITY`, `STATE`, `ZIPCODE`, `USERS_ID`) VALUES (:business_email, :phone, :aboutMe, :street, :city, :state, :zipcode, :user_id)");
            //binds parameters
            $stmt->bindParam(':business_email', $businessEmail);
            $stmt->bindParam(':phone', $phoneNumber);
            $stmt->bindParam(':aboutMe', $aboutMe);
            $stmt->bindParam(':street', $streetAddress);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':zipcode', $zipcode);
            $stmt->bindParam(':user_id', $user_id);
            
            /*return true if success
             else return false if not created*/
            if ($stmt->execute()) {
                Log::info("Exit ProfileDataService.createContactInfo() with true");
                return true;
            }
            
            else {
                Log::info("Exit ProfileDataService.createContactInfo() with false");
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
     * Finds the user contact info by id
     * @param $id
     * @throws DatabaseException
     * @return array
     */
    public function findContactByID($id) {
        Log::info("Entering ProfileDataService.findContactByID()");
        
        try {
            //prepared statement is created and user id is binded 
            $stmt = $this->conn->prepare('SELECT * FROM contact WHERE USERS_ID = :id');
            $stmt->bindParam(':id', $id);
            
            //array is created and statement is executed
            $list = array();
            $stmt->execute();
            
            //loops through table  using stmt->fetch
            for ($i = 0; $row = $stmt->fetch(); $i++) {
                //contact model is created 
                $contactInfo = new ContactModel($row['ID'], $row['BUSINESS_EMAIL'], $row['PHONE'], $row['ABOUT'], $row['STREET'], $row['CITY'], $row['STATE'], $row['ZIPCODE'], $id);
                //inserts variables into end of array
                array_push($list, $contactInfo);
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
    
    /**
     * Updates user contact info in database
     * @param ContactModel $contactInfo
     * @throws DatabaseException
     * @return boolean
     */
    public function updateContactInfo(ContactModel $contactInfo)
    {
        Log::info("Entering ProfileDataService.updateContactInfo()");
        try {
            // select variables and see if the row exists
            $id = $contactInfo->getId();
            $businessEmail = $contactInfo->getBusinessEmail();
            $phoneNumber = $contactInfo->getPhone();
            $aboutMe = $contactInfo->getAboutMe();
            $streetAddress = $contactInfo->getStreetAddress();
            $city = $contactInfo->getCity();
            $state = $contactInfo->getState();
            $zipcode = $contactInfo->getZipcode();
            
            // prepared statements is created
            $stmt = $this->conn->prepare("UPDATE contact SET `BUSINESS_EMAIL` = :business_email, `PHONE` = :phone, `ABOUT` = :aboutMe, `STREET` = :street, `CITY` = :city, `STATE` = :state, `ZIPCODE` = :zipcode WHERE `ID` = :contact_id");
            // binds parameters
            $stmt->bindParam(':contact_id', $id);
            $stmt->bindParam(':business_email', $businessEmail);
            $stmt->bindParam(':phone', $phoneNumber);
            $stmt->bindParam(':aboutMe', $aboutMe);
            $stmt->bindParam(':street', $streetAddress);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':zipcode', $zipcode);
            $stmt->execute();
            
            /*
             * return true if data was inserted
             * else return false if unsuccessful
             */
            if ($stmt->rowCount() == 1) {
                Log::info("Exit ProfileDataService.updateContactInfo() with true");
                return true;
            } else {
                Log::info("Exit ProfileDataService.updateContactInfo() with false");
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
    
    //delete contact info
    /**
     * Deletes user contact info from database
     * @param $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteContact($id) {
        Log::info("Entering ProfileDataService.deleteContact()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM contact WHERE `USERS_ID` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if contact info has been deleted from database
            if ($delete) {
                Log::info("Exiting ProfileDataService.deleteContact() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting ProfileDataService.deleteContact() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
  
    /**
     * Creates user education
     * @param EducationModel $education
     * @throws DatabaseException
     * @return boolean
     */
    public function createEducation(EducationModel $education) {
        Log::info("Entering ProfileDataService.createEducation()");
        
        try {
            //select variables and see if row exists
            $degree = $education->getDegree();
            $school = $education->getSchoolName();
            $city = $education->getCity();
            $state = $education->getState();
            $graduation = $education->getGraduationYear();
            $user_id = $education->getUser_id();
            
            //prepared statement is created
            $stmt = $this->conn->prepare("INSERT INTO `education` (`DEGREE`, `SCHOOL`, `CITY`, `STATE`, `GRADUATION`, `USERS_ID`) VALUES (:degree, :school, :city, :state, :graduation, :user_id)");
            //binds parameters
            $stmt->bindParam(':degree', $degree);
            $stmt->bindParam(':school', $school);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':graduation', $graduation);
            $stmt->bindParam(':user_id', $user_id);
            
            /*see if education is created and return true if success
             else return false if not created*/
            if ($stmt->execute()) {
                Log::info("Exit ProfileDataService.createEducation() with true");
                return true;
            }
            
            else {
                Log::info("Exit ProfileDataService.createEducation() with false");
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
     * Finds user education by id 
     * @param $id
     * @throws DatabaseException
     * @return array
     */
    public function findEducationByID($id) {
        Log::info("Entering ProfileDataService.findEducationByID()");
        
        try {
            //prepared statement is created and user id is binded
            $stmt = $this->conn->prepare('SELECT * FROM education WHERE USERS_ID = :id');
            $stmt->bindParam(':id', $id);
            
            //list array is created and statement is executed
            $list = array();
            $stmt->execute();
            
            //loops through table using stmt->fetch
            for ($i = 0; $row = $stmt->fetch(); $i++) {
                //education model is created 
                $education = new EducationModel($row['ID'], $row['DEGREE'], $row['SCHOOL'], $row['CITY'], $row['STATE'], $row['GRADUATION'], $id);
                //inserts variables into end of array
                array_push($list, $education);
            }
            
            //return list array that holds education variables
            Log::info("Exit ProfileDataService.findEducationByID() with true");
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
     * Updates user education info in database
     * @param EducationModel $education
     * @throws DatabaseException
     * @return boolean
     */
    public function updateEducation(EducationModel $education)
    {
        Log::info("Entering ProfileDataService.updateEducation()");
        try {
            // select variables and see if the row exists
            $id = $education->getId();
            $degree = $education->getDegree();
            $school = $education->getSchoolName();
            $city = $education->getCity();
            $state = $education->getState();
            $graduation = $education->getGraduationYear();
            
            // prepared statements is created
            $stmt = $this->conn->prepare("UPDATE education SET DEGREE = :degree, SCHOOL = :school, CITY = :city, STATE = :state, GRADUATION = :graduation WHERE ID = :id");
            // binds parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':degree', $degree);
            $stmt->bindParam(':school', $school);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':graduation', $graduation);
            
            $stmt->execute();
            /*
             * return true new data was inserted
             * else return false if failed
             */
            if ($stmt->rowCount() == 1) {
                Log::info("Exit ProfileDataService.updateEducation() with true");
                return true;
            } else {
                Log::info("Exit ProfileDataService.updateEducation() with false");
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
     * Deletes user education from database
     * @param  $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteEducation($id) {
        Log::info("Entering ProfileDataService.deleteEducation()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM education WHERE `ID` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if education has been deleted from database
            if ($delete) {
                Log::info("Exiting ProfileDataService.deleteEducation() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting ProfileDataService.deleteEducation() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Creates user job history
     * @param JobHistoryModel $history
     * @throws DatabaseException
     * @return boolean
     */
    public function createJobHistory(JobHistoryModel $history) {
        Log::info("Entering ProfileDataService.createJobHistory()");
        
        try {
            //select variables and see if row exists
            $previous = $history->getPreviousJobTitle();
            $description = $history->getPreviousJobDescription();
            $start = $history->getStartDate();
            $end = $history->getEndDate();
            $company = $history->getCompanyName();
            $city = $history->getCity();
            $state = $history->getState();
            $user_id = $history->getUser_id();
            
            //prepared statement is created
            $stmt = $this->conn->prepare("INSERT INTO `job_history` (`PREVJOB`, `PREVJOBDESC`, `STARTDATE`, `ENDDATE`, `COMPANY`, `CITY`, `STATE`, `USERS_ID`) VALUES (:prevTitle, :description, :startDate, :endDate, :company, :city, :state, :user_id)");
            //binds parameters
            $stmt->bindParam(':prevTitle', $previous);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':startDate', $start);
            $stmt->bindParam(':endDate', $end);
            $stmt->bindParam(':company', $company);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':user_id', $user_id);
            
            /*see if job history is created and return true if success
             else return false if not created*/
            if ($stmt->execute()) {
                Log::info("Exit ProfileDataService.createJobHistory() with true");
                return true;
            }
            
            else {
                Log::info("Exit ProfileDataService.createJobHistory() with false");
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
     * Finds user job history by id
     * @param $id
     * @throws DatabaseException
     * @return array
     */
    public function findJobHistoryByID($id) {
        Log::info("Entering ProfileDataService.findJobHistoryByID()");
        
        try {
            
            //prepared statement is created and user id is binded
            $stmt = $this->conn->prepare('SELECT * FROM job_history WHERE USERS_ID = :id');
            $stmt->bindParam(':id', $id);
            
            //list array is created and statement is executed
            $list = array();
            $stmt->execute();

            //loops through table  using stmt->fetch
            for ($i = 0; $row = $stmt->fetch(); $i++) {
                //contact model is created
                $history = new JobHistoryModel($row['ID'], $row['PREVJOB'], $row['PREVJOBDESC'], $row['STARTDATE'], $row['ENDDATE'], $row['COMPANY'], $row['CITY'], $row['STATE'], $id);
                //inserts variables into end of array
                array_push($list, $history);
            }
            
            //return list array that holds job history variables
            Log::info("Exit ProfileDataService.findJobHistoryByID() with true");
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
     * Updates user job history info in database
     * @param JobHistoryModel $jobHistory
     * @throws DatabaseException
     * @return boolean
     */
    public function updateJobHistory(JobHistoryModel $jobHistory)
    {
        Log::info("Entering ProfileDataService.updateJobHistory()");
        try {
            // select variables and see if the row exists
            $id = $jobHistory->getId();
            $prevTitle = $jobHistory->getPreviousJobTitle();
            $prevDesc = $jobHistory->getPreviousJobDescription();
            $startDate = $jobHistory->getStartDate();
            $endDate = $jobHistory->getEndDate();
            $companyName = $jobHistory->getCompanyName();
            $city = $jobHistory->getCity();
            $state = $jobHistory->getState();
            
            // prepared statements is created
            $stmt = $this->conn->prepare("UPDATE job_history SET PREVJOB = :prevJob, PREVJOBDESC = :prevDesc, STARTDATE = :startDate, ENDDATE = :endDate, COMPANY = :company, CITY = :city, STATE = :state WHERE ID = :id");
            // binds parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':prevJob', $prevTitle);
            $stmt->bindParam(':prevDesc', $prevDesc);
            $stmt->bindParam(':startDate', $startDate);
            $stmt->bindParam(':endDate', $endDate);
            $stmt->bindParam(':company', $companyName);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':state', $state);
            
            $stmt->execute();
            /*
             * return true if new data was inserted
             * else return false if failed
             */
            if ($stmt->rowCount() == 1) {
                Log::info("Exit ProfileDataService.updateJobHistory() with true");
                return true;
            } else {
                Log::info("Exit ProfileDataService.updateJobHistory() with false");
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
     * Deletes user job history from database
     * @param  $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteJobHistory($id) {
        Log::info("Entering ProfileDataService.deleteJobHistory()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM job_history WHERE `ID` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if job history has been deleted from database
            if ($delete) {
                Log::info("Exiting ProfileDataService.deleteJobHistory() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting ProfileDataService.deleteJobHistory() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Creates user skill
     * @param SkillsModel $skills
     * @throws DatabaseException
     * @return boolean
     */
    public function createSkills(SkillsModel $skills) {
        Log::info("Entering ProfileDataService.createSkills()");
        
        try {
            //select variables and see if row exists
            $userSkills = $skills->getUserSkill();
            $user_id = $skills->getUser_id();
            
            //prepared statement is created
            $stmt = $this->conn->prepare("INSERT INTO `skills` (`SKILL`, `USERS_ID`) VALUES (:skills, :user_id)");
            //binds parameters
            $stmt->bindParam(':skills', $userSkills);
            $stmt->bindParam(':user_id', $user_id);
            
            /*see if skills is created and return true if success
             else return false if not created*/
            if ($stmt->execute()) {
                Log::info("Exit ProfileDataService.createSkills() with true");
                return true;
            }
            
            else {
                Log::info("Exit ProfileDataService.createSkills() with false");
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
     * Finds user skills by id
     * @param $id
     * @throws DatabaseException
     * @return array
     */
    public function findSkillsByID($id) {
        Log::info("Entering ProfileDataService.findSkillsByID()");
        
        try {
            //prepared statement is created and user id is binded
            $stmt = $this->conn->prepare('SELECT * FROM skills WHERE USERS_ID = :id');
            $stmt->bindParam(':id', $id);
            
            //list array is created and statement is executed
            $list = array();
            $stmt->execute();
            
            //loops through table  using stmt->fetch
            for ($i = 0; $row = $stmt->fetch(); $i++) {
                //skills model is created 
                $skills = new SkillsModel($row['ID'], $row['SKILL'], $id);
                //inserts variables into end of array
                array_push($list, $skills);
            }
            //return list array that holds contact variables
            Log::info("Exit ProfileDataService.findSkillsByID() with true");
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
     * Updates user skill info in database
     * @param SkillsModel $skill
     * @throws DatabaseException
     * @return boolean
     */
    public function updateSkills(SkillsModel $skill)
    {
        Log::info("Entering ProfileDataService.updateJobHistory()");
        try {
            // select variables and see if the row exists
            $id = $skill->getId();
            $userSkill = $skill->getUserSkill();
            
            // prepared statements is created
            $stmt = $this->conn->prepare("UPDATE skills SET SKILL = :skill WHERE ID = :id");
            // binds parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':skill', $userSkill);
            
            $stmt->execute();
            /*
             * return true if new data was inserted
             * else return false if failed
             */
            if ($stmt->rowCount() == 1) {
                Log::info("Exit ProfileDataService.updateSkills() with true");
                return true;
            } else {
                Log::info("Exit ProfileDataService.updateSkills() with false");
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
     * Deletes user skill from database
     * @param $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteSkill($id) {
        Log::info("Entering ProfileDataService.deleteSkill()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM skills WHERE `ID` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if skill has been deleted from database
            if ($delete) {
                Log::info("Exiting ProfileDataService.deleteSkill() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting ProfileDataService.deleteSkill() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Finds each member from group by id
     * @param  $id
     * @throws DatabaseException
     * @return array
     */
    public function findGroupMember($id) {
        Log::info("Entering ProfileDataService.findGroupMember()");
        
        try {
            //prepared statement is created and user id is binded
            $stmt = $this->conn->prepare('SELECT * FROM user_groups WHERE USERS_ID = :id');
            $stmt->bindParam(':id', $id);
            
            //array is created and statement is executed
            $list = array();
            $stmt->execute();
            
            //loops through table  using stmt->fetch
            for ($i = 0; $row = $stmt->fetch(); $i++) {
                //contact model is created
                $userGroup = new UserGroupModel($row['ID'], $row['GROUPS_ID'], $id);
                //inserts variables into end of array
                array_push($list, $userGroup);
            }
            //return list array that holds contact variables
            Log::info("Exit ProfileDataService.findGroupMember() with true");
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
     * Adds user to an existing group
     * @param UserGroupModel $userGroup
     * @throws DatabaseException
     * @return boolean
     */
    public function createUserGroup(UserGroupModel $userGroup) {
        Log::info("!!!Entering ProfileDataService.createUserGroup()");
            try {
                //select variables and see if row exists
                $group_id = $userGroup->getGroup_id();
                $user_id = $userGroup->getUser_id();
                
                //prepared statement is created
                $stmt = $this->conn->prepare("INSERT INTO `user_groups` (`GROUPS_ID`, `USERS_ID`) VALUES (:group_id, :user_id)");
                //binds parameters
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':group_id', $group_id);
                
                /*see if user group was created and return true if success
                 else return false if not created*/
                if ($stmt->execute()) {
                    Log::info("Exit ProfileDataService.createUserGroup() with true");
                    return true;
                }
                
                else {
                    Log::info("Exit ProfileDataService.craeteUserGroup() with false");
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
     * Removes user from group
     * @param  $id
     * @throws DatabaseException
     * @return boolean
     */
    public function deleteUserGroup($id) {
        Log::info("Entering ProfileDataService.deleteUserGroup()");
        
        try {
            //prepared statement is created
            $stmt = $this->conn->prepare('DELETE FROM `user_groups` WHERE `groups_id` = :id');
            //bind parameter
            $stmt->bindParam(':id', $id);
            //executes statement
            $delete = $stmt->execute();
            
            //returns true or false if skill has been deleted from database
            if ($delete) {
                Log::info("Exiting ProfileDataService.deleteSkill() with returning true");
                return true;
            }
            
            else {
                Log::info("Exiting ProfileDataService.deleteSkill() with returning false");
                return false;
            }
        }
        
        catch (\PDOException $e) {
            Log::error("Exception: ", array("message" => $e->getMessage()));
            throw new DatabaseException("Database Exception: " . $e->getMessage(), 0, $e);
        }
    }
    
    /**
     * Allows user to apply to a job
     * @param UserJobModel $userJob
     * @throws DatabaseException
     * @return boolean
     */
    public function createUserJob(UserJobModel $userJob) {
        try {
            //select variables and see if row exists
            $job_id = $userJob->getJob_id();
            $user_id = $userJob->getUser_id();
           
            //prepared statement is created
            $stmt = $this->conn->prepare("INSERT INTO `user_job` (`JOB_POSTING_ID`, `USERS_ID`) VALUES (:job_id, :user_id)");
            //binds parameters
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':job_id', $job_id);
            
            /*see if user job was created and return true if success
             else return false if not created*/
            if ($stmt->execute()) {
                Log::info("Exit ProfileDataService.createUserJob() with true");
                return true;
            }
            
            else {
                Log::info("Exit ProfileDataService.createUserJob() with false");
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
}
