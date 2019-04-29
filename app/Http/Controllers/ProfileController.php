<?php
//Milestone 3
//Emily Quevedo
//February 20, 2019
//This is my own work

/* Profile controller processes the submitted data for user profile */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Services\Business\ProfileBusinessService;
use App\Services\Business\AdminBusinessService;
use App\Services\Utility\ILoggerService;
use App\Models\ContactModel;
use App\Models\UserGroupModel;
use App\Models\UserJobModel;

class ProfileController extends Controller
{
    /**
     * Uses the logger service to log any messages
     * @param ILoggerService $logger
     */
    public function __construct(ILoggerService $logger) {
        $this->logger = $logger;
    }
    
    /**
     * This method is to find the user's profile
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function findProfile() {
        try{
            $this->logger->info("Entering ProfileController.findProfile()");
            
        //get session user id
        $id = session()->get('user_id');
        
        //call business service class
        $service = new ProfileBusinessService();
        
        //access find by id methods 
        $contactInfo = $service->findContactByID($id);
        
        $skills = $service->findSkillsByID($id);
        
        $education = $service->findEducationByID($id);
        
        $jobHistory = $service->findJobHistoryByID($id);
        
        //process results from business service (navigation)
        //render the user profile view and pass the profile array to it
        $profile = ['contactInfo' => $contactInfo, 'skills' => $skills, 'education' => $education, 'history' => $jobHistory];
        
        return view('profile')->with($profile);
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    

    /**
     * This method is to find the user's contact info
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function findContactInfo() {
        try {
            $this->logger->info("Entering ProfileController.findContactInfo()");
            //get posted form data
            $id = session()->get('user_id');
            
            //call security business service
            $service = new ProfileBusinessService();
            $contactInfo = $service->findContactByID($id);
            
            //process results from business service (navigation)
            //render a failed or edit contact info response view and pass the contact info model to it
            if ($contactInfo) {
                return view('editContactInfo')->with('contactInfo', $contactInfo);
            }
            
            else {
                return false;
            }
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    /**
     * This method allows the user to insert their contact info
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createContactInfo(Request $request) {
        try {
            $this->logger->info("Entering ProfileController.createContactInfo()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);

            //get posted form data
            $email = $request->input('business_email');
            $phone = $request->input('phone');
            $about = $request->input('aboutMe');
            $street = $request->input('street');
            $city = $request->input('city');
            $state = $request->input('state');
            $zipcode = $request->input('zipcode');
            
            if ($request->session()->has('user_id')) {
                $user_id = $request->session()->get('user_id');
            }
            
            //create object model and save posted form data in user object model
            $userContact = new ContactModel(-1, $email, $phone, $about, $street, $city, $state, $zipcode, $user_id);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->addContactInfo($userContact);
            
            //process results from business service (navigation)
            //render a failed or redirect to user profile view
            if ($status) {
                return redirect()->action('ProfileController@findProfile');
            }
            
            else {
                return view('profileFail');
            }
        }
        
        catch (ValidationException $e1) {
            //note: this exception must be caught before exception bc validationexception extends from exception
            //must rethrow this exception in order for laravel to display your submitted page with errors
            //catch and rethrow data validation exception (so we can catch all others in our next exception catch block
            throw $e1;
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    /**
     * This method is to update the user's contact info
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateContactInfo(Request $request) {
            try {
                $this->logger->info("Entering ProfileController.updateContactInfo()");
                //validate the form date
                //view if errors
                $this->validateForm($request);
                
                //get posted form data
                $id = $request->input('id');
                $email = $request->input('business_email');
                $phone = $request->input('phone');
                $about = $request->input('aboutMe');
                $street = $request->input('street');
                $city = $request->input('city');
                $state = $request->input('state');
                $zipcode = $request->input('zipcode');
                
                if ($request->session()->has('user_id')) {
                    $user_id = $request->session()->get('user_id');
                }
                
                //create object model and save posted form data in contact object model
                $userContact = new ContactModel($id, $email, $phone, $about, $street, $city, $state, $zipcode, $user_id);
                
                //execute business service and call security business service
                $service = new ProfileBusinessService();
                $status = $service->editContactInfo($userContact);
                
                //process results from business service (navigation)
                //render a failed or redirect to profile view
                if ($status) {
                    
                    return redirect()->action('ProfileController@findProfile');
                }
                
                else {
                    return view('profileFail');
                }
            }
            
            catch (ValidationException $e1) {
                //note: this exception must be caught before exception bc validationexception extends from exception
                //must rethrow this exception in order for laravel to display your submitted page with errors
                //catch and rethrow data validation exception (so we can catch all others in our next exception catch block
                throw $e1;
            }
            
            catch (Exception $e){
                //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
                //log exception and display exception view
                $this->logger->error("Exception: ", array("message" => $e->getMessage()));
                $data = ['errorMsg' => $e->getMessage()];
                return view('exception')->with($data);
            }
    }
    
    /**
     * This method is to delete the user's contact info
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function deleteContact(Request $request) {
        try {
            $this->logger->info("Entering ProfileController.deleteContact()");
            //GET method for user id
            $id = $request->session()->get('user_id');
            //call user business service
            $service = new ProfileBusinessService();
            $delete = $service->removeContactInfo($id);
            
            //render a success or fail view
            if($delete) {
                return redirect()->action('ProfileController@findProfile');
            }
            
            else {
                return view('deleteFail');
            }
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    /**
     * This method is to find a group by id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function showGroupByID() {
        try {
            $this->logger->info("Entering ProfileController.showGroupByID()");
            //1. process form data
            //get posted form data
            $id = $_GET['id'];
            
            //call security business service
            $service = new AdminBusinessService();
            $groups = $service->findGroupByID($id);
            
            //process results from business service (navigation)
            //render a failed or success response view and pass the job posting model to it
            
            if ($groups) {
                return view('groupView')->with('groups', $groups);
            }
            
            else {
                return false;
            }
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    /**
     * This method is to find the group members by id 
     * @param Request $request
     * @return void|boolean|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showGroupMembers(Request $request) {
        try {
            $this->logger->info("Entering ProfileController.showGroupMembers()");
            //get posted form data
            $id = $request->session()->get('user_id');
            
            //call security business service
            $service = new ProfileBusinessService();
            $userGroup = $service->findGroupMemberByID($id);
            
            //process results from business service (navigation)
            //render a failed or edit contact info response view and pass the contact info model to it
            if ($userGroup) {
                return view('userGroup')->with('userGroup', $userGroup);
            }
            
            else {
                return false;
            }
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    /**
     * This method allows the user to join a group
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function joinGroup(Request $request) {
            try {
                $this->logger->info("Entering ProfileController.joinGroup()");
                
                //get posted form data
                $group_id = $request->input('id');
                
                
                if ($request->session()->has('user_id')) {
                    $user_id = $request->session()->get('user_id');
                }
                
                //create object model and save posted form data in skills object model
                $userGroup = new UserGroupModel(0, $group_id, $user_id);
                
                //execute business service and call security business service
                $service = new ProfileBusinessService();
                $status = $service->addUserGroup($userGroup);
                
                //process results from business service (navigation)
                //render a failed or redirect to user profile view
                
                if ($status) {
                    return view('userGroupSuccess');
                }
                
                else {
                    return view('userGroup2');
                }
            }
            
            catch (Exception $e){
//                 best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
//                 log exception and display exception view
                $this->logger->error("Exception: ", array("message" => $e->getMessage()));
                $data = ['errorMsg' => $e->getMessage()];
               return view('exception')->with($data);
            }
        }
    
    /**
     * This method allows for the user to leave a group
     * @param Request $request
     * @return string|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function leaveGroup(Request $request) {
        try {
            $this->logger->info("Entering ProfileController.leaveGroup()");
            //GET method for user id
            $id = $request->input('id');
            //call user business service
            $service = new ProfileBusinessService();
            $delete = $service->removeUserFromGroup($id);
            
            //render a success or fail view
            if($delete) {
                return view('groupList');
            }
            
            else {
                return view('deleteFail');
            }
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    /**
     * This method allows the user to apply to a job post
     * @param Request $request
     * @return string|boolean|\Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function applyToJob(Request $request) {
        try {
            $this->logger->info("Entering ProfileController.applyToJob()");
            //get posted form data
            $job_id = $request->input('id');
            
            
            if ($request->session()->has('user_id')) {
                $user_id = $request->session()->get('user_id');
            }
            
            //create object model and save posted form data in user job object model
            $userJob = new UserJobModel(0, $job_id, $user_id);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->addUserJob($userJob);
            
            //process results from business service (navigation)
            //render a failed or redirect to user profile view
            
            if ($status) {
                return view('jobApplySuccess');
            }
            
            else {
                return false;
            }
        }
        
        catch (Exception $e){
            //                 best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //                 log exception and display exception view
            $this->logger->error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    private function validateForm(Request $request){
        //best practice: centralize your rules so you have a consistent architecture and even reuse your rules
        //bad practice: not using a defined data validation framework, putting rules all over your code, doing only on client side or database
        //setup data validation rules for login form
        $rules = ['business_email' => 'Required | Between:4,50',
            'phone' => 'Required | Between:10,11', 'aboutMe' => 'Required | Between:2,100', 'street' => 'Required | Between:4,50', 'city' => 'Required | Between:4,50', 'state' => 'Required | Between:4,50', 'zipcode' => 'Required | Between:5,6'];
        
//         run data validation rules
         $this->validate($request, $rules);
    }
}