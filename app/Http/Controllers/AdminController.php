<?php
//Milestone 5
//Emily Quevedo
//March 10, 2019
//This is my own work

/* Admin controller handles user admin methods */
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Services\Business\AdminBusinessService;
use App\Services\Utility\ILoggerService;
use App\Models\AffinityGroupModel;

class AdminController extends Controller {

    public function __construct(ILoggerService $logger) {
        $this->logger = $logger;
    }
    
/**
 * This method is to display all users from database
 * @param Request $request
 * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
 */
public function index(Request $request) {
   try {
       $this->logger->info("Entering AdminController.index()");
        //call user business service
        $service = new AdminBusinessService();
        $users = $service->showUsers();
        //render a response view
        if ($users) {
        return view('displayUsers')->with($users);
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
     * This method is to delete user from database
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function deleteUser() {
        try {
            $this->logger->info("Entering AdminController.deleteUser()");
            //GET method for user id
            $id = $_GET['id'];
            //call user business service
            $service = new AdminBusinessService();
            $delete = $service->removeUser($id);
            
            //render a success or fail view
            if($delete) {
                return view('deleteSuccess');
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
     * This method is to suspend user
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function suspendUser() {
        try {
            $this->logger->info("Entering AdminController.suspendUser()");
            //GET method for user id
            $id = $_GET['id'];
            //call user business service
            $service = new AdminBusinessService();
            $suspend = $service->suspendUser($id);
            //renders a success or fail view 
            if($suspend) {
                return view('suspendSuccess');
            }
            
            else {
                return view('suspendFail');
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
     * This method is to unsuspend user
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function unsuspendUser() {
        try {
            $this->logger->info("Entering AdminController.unsuspendUser()");
            //GET method for user id
            $id = $_GET['id'];
            //calls user business service
            $service = new AdminBusinessService();
            $unsuspend = $service->unsuspendUser($id);
            //renders a success or fail view
            if($unsuspend) {
                return view('unsuspendSuccess');
            }
            
            else {
                return view('unsuspendFail');
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
     * This method to create an affinity group
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function addGroup(Request $request) {
        try {
            $this->logger->info("Entering AdminController.addGroup()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);
             
            //recieves data inputed from user
            $name = $request->input('groupName');
            $description = $request->input('groupDesc');
            
            //create object model and save posted form data in user object model
            $group = new AffinityGroupModel(0, $name, $description);
            
            //execute business service and call security business service
            $service = new AdminBusinessService();
            $status = $service->addGroup($group);
            
            //process results from business service (navigation)
            //render a failed or redirect to table of all jobs
            if ($status) {
                
                return redirect()->action('AdminController@displayAllGroups');
            }
            
            else {
                return "Failed";
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
     * This methos is to display all groups from the database
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function displayAllGroups() {
        try {
            $this->logger->info("Entering AdminController.displayAllGroup()");
            //call user business service
            $service = new AdminBusinessService();
            $group = $service->showGroups();
            //render a response view
            if ($group) {
                return view('displayGroups')->with($group);
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
    public function findGroup() {
        try {
            $this->logger->info("Entering AdminController.findGroup()");
            //1. process form data
            //get posted form data
            $id = $_GET['id'];
            
            //call security business service
            $service = new AdminBusinessService();
            $groups = $service->findGroupByID($id);
            
            //process results from business service (navigation)
            //render a failed or success response view and pass the job posting model to it
            
            if ($groups) {
                return view('editGroup')->with('groups', $groups);
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
     * This method is to update information about a group
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function updateGroup(Request $request) {
        try {
            $this->logger->info("Entering AdminController.updateGroup()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
           $this->validateForm($request);
            
            //recieves data inputed from user
            $id = $request->input('id');
            $name = $request->input('groupName');
            $description = $request->input('groupDesc');
            
            //create object model and save posted form data in user object model
            $group = new AffinityGroupModel($id, $name, $description);
            
            //execute business service and call security business service
            $service = new AdminBusinessService();
            $status = $service->editGroup($group);
            
            //process results from business service (navigation)
            //render a failed or redirect to table that displays all jobs
            if ($status) {
                
                return redirect()->action('AdminController@displayAllGroups');
            }
            
            else {
                return false;
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
    
    //method to delete group
    /**
     * This method is to delete the group from the database
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteGroup() {
        try {
            $this->logger->info("Entering AdminController.deleteGroup()");
            //GET method for user id
            $id = $_GET['id'];
            //call user business service
            $service = new AdminBusinessService();
            $delete = $service->removeGroup($id);
            
            //render a success or fail view
            if($delete) {
                return redirect()->action('AdminController@displayAllGroups');
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
    
    private function validateForm(Request $request){
        //best practice: centralize your rules so you have a consistent architecture and even reuse your rules
        //bad practice: not using a defined data validation framework, putting rules all over your code, doing only on client side or database
        //setup data validation rules for login form
                $rules = ['groupName' => 'Required | Between:4,50', 'groupDesc' => 'Required | Between:4,100'];
        
//                 run data validation rules
                 $this->validate($request, $rules);
    }
}