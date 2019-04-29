<?php
//Emily Quevedo
//February 28, 2019
//This is my own work

/* Job History controller handles user job history methods */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models\JobHistoryModel;
use App\Services\Business\ProfileBusinessService;
use App\Services\Utility\ILoggerService;


class JobHistoryController extends Controller {

    /**
     * Uses the logger service to log any messages
     * @param ILoggerService $logger
     */
    public function __construct(ILoggerService $logger) {
        $this->logger = $logger;
    }
    
    /**
     * This method is to find the user's job history info
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function findJobHistory() {
        try {
            $this->logger->info("Entering JobHistoryController.findJobHistory()");
            //get posted form data
            $id = session()->get('user_id');
            
            //call security business service
            $service = new ProfileBusinessService();
            $history = $service->findJobHistoryByID($id);
            
            //process results from business service (navigation)
            //render a failed or edit job history view and pass the job history model to it
            if ($history) {
                return view('editHistory')->with('history', $history);
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
     * This method is to allow user to insert their job history info
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createJobHistory(Request $request) {
        try {
            $this->logger->info("Entering JobHistoryController.createJobHistory()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);
            
            //get posted form data
            $previousJobTitle = $request->input('prevTitle');
            $previousJobDescription = $request->input('description');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $companyName = $request->input('company');
            $city = $request->input('city');
            $state = $request->input('state');
            
            if ($request->session()->has('user_id')) {
                $user_id = $request->session()->get('user_id');
            }
            
            //create object model and save posted form data in job history object model
            $userHistory = new JobHistoryModel(-1, $previousJobTitle, $previousJobDescription, $startDate, $endDate, $companyName, $city, $state, $user_id);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->addJobHistory($userHistory);
            
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
     * This method is to update the job history info
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateJobHistory(Request $request) {
        try {
            $this->logger->info("Entering JobHistoryController.updateJobHistory()");
            //validate the form date
            //view if errors
            $this->validateForm($request);
            
            //get posted form data
            $id = $request->input('id');
            $previousJobTitle = $request->input('prevTitle');
            $previousJobDescription = $request->input('description');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $companyName = $request->input('company');
            $city = $request->input('city');
            $state = $request->input('state');
            
            //create object model and save posted form data in job history object model
            $userHistory = new JobHistoryModel($id, $previousJobTitle, $previousJobDescription, $startDate, $endDate, $companyName, $city, $state, 0);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->editJobHistory($userHistory);
            
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
     * This method is to delete the user's job history from the database
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteJobHistory() {
        try {
            $this->logger->info("Entering JobHistoryController.deleteJobHistory()");
            //GET method for user id
            $id = $_GET['id'];
            //call user business service
            $service = new ProfileBusinessService();
            $delete = $service->removeJobHistory($id);
            
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
                $rules = ['prevTitle' => 'Required | Between:4,50', 'description' => 'Required | Between:4,50', 'startDate' => 'Required', 'endDate' => 'Required', 'company' => 'Required | Between:4,50', 'city' => 'Required | Between:4,50', 'state' => 'Required | Between:4,50'];
        
        //         run data validation rules
                 $this->validate($request, $rules);
    }
}