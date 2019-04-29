<?php
//Emily Quevedo
//February 28, 2019
//This is my own work

/* Education controller handles user education methods */
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\EducationModel;
use App\Services\Business\ProfileBusinessService;
use App\Services\Utility\ILoggerService;

class EducationController extends Controller {
    /**
     * Uses the logger service to log any messages
     * @param ILoggerService $logger
     */
    public function __construct(ILoggerService $logger) {
        $this->logger = $logger;
    }
    
    /**
     * This method is to find the user's education
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function findEducation() {
        try {
            $this->logger->info("Entering EducationController.findEducation()");
            //get posted form data
            $id = session()->get('user_id');
            
            //call security business service
            $service = new ProfileBusinessService();
            $education = $service->findEducationByID($id);
            
            //process results from business service (navigation)
            //render a failed or edit education view and pass the education model to it
            
            if ($education) {
                return view('editEducation')->with('education', $education);
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
     * This method allows for the user to insert their education info
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createEducation(Request $request) {
        try {
            $this->logger->info("Entering EducationController.createEducation()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);
            
            //get posted form data
            $degree = $request->input('degree');
            $school = $request->input('school');
            $city = $request->input('city');
            $state = $request->input('state');
            $graduation = $request->input('graduation');
            
            if ($request->session()->has('user_id')) {
                $user_id = $request->session()->get('user_id');
            }
            
            //create object model and save posted form data in education object model
            $userEducation = new EducationModel(-1, $degree, $school, $city, $state, $graduation, $user_id);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->addEducation($userEducation);
            
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
    
    //method to update user education
    /**
     * This method is to update the user's education info
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEducation(Request $request) {
        try {
            $this->logger->info("Entering EducationController.updateEducation()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);
            
            //get posted form data
            $id = $request->input('id');
            $degree = $request->input('degree');
            $school = $request->input('school');
            $city = $request->input('city');
            $state = $request->input('state');
            $graduation = $request->input('graduation');
            
            if ($request->session()->has('user_id')) {
                $user_id = $request->session()->get('user_id');
            }
            
            //create object model and save posted form data in user object model
            $userEducation = new EducationModel($id, $degree, $school, $city, $state, $graduation, $user_id);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->editEducation($userEducation);
            
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
    
    //delete education
    /**
     * This method is to delete the user's education info based on selection
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteEducation() {
        try {
            $this->logger->info("Entering EducationController.deleteEducation()");
            //GET method for user id
            $id = $_GET['id'];
            //call user business service
            $service = new ProfileBusinessService();
            $delete = $service->removeEducation($id);
            
            //render page redirect to user profile view or fail view
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
    
    private function validateForm(Request $request){
        //best practice: centralize your rules so you have a consistent architecture and even reuse your rules
        //bad practice: not using a defined data validation framework, putting rules all over your code, doing only on client side or database
        //setup data validation rules for login form
       $rules = ['degree' => 'Required | Between:4,50',
                    'school' => 'Required | Between:2,50', 'city' => 'Required | Between:4,50', 'state' => 'Required | Between:4,50', 'graduation' => 'Required'];        
       //run data validation rules
       $this->validate($request, $rules);
    }
}