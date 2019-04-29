<?php
//Emily Quevedo
//February 28, 2019
//This is my own work

/* Job Posting controller handles admin job posting methods */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\JobModel;
use App\Services\Business\AdminBusinessService;
use Exception;
use App\Services\Business\JobPostingBusinessService;
use App\Services\Utility\ILoggerService;

class JobPostingController extends Controller{

    /**
     * Uses the logger service to log any messages
     * @param ILoggerService $logger
     */
    public function __construct(ILoggerService $logger) {
        $this->logger = $logger;
    }
    
    /**
     * This method is to create a new job post
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function addJobPosting(Request $request) {
        try {
            $this->logger->info("Entering JobPostingController.addJobPosting()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);
            
            //recieves data inputed from user
            $jobTitle = $request->input('title');
            $position = $request->input('position');
            $jobDescription = $request->input('jobDescription');
            $employerName = $request->input('companyName');
            $employerCity = $request->input('companyCity');
            $employerState = $request->input('companyState');
            $datePosted = $request->input('datePosted');
            
            //create object model and save posted form data in user object model
            $job = new JobModel(0, $jobTitle, $position, $jobDescription, $employerName, $employerCity, $employerState, $datePosted);
            
            //execute business service and call security business service
            $service = new AdminBusinessService();
            $status = $service->addJobPosting($job);
            
            //process results from business service (navigation)
            //render a failed or redirect to table of all jobs
            if ($status) {
                
                return redirect()->action('JobPostingController@displayAllJobs');
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
     * This method is to display all jobs from the database
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function displayAllJobs() {
        try {
            $this->logger->info("Entering JobPostingController.displayAllJobs()");
            //call user business service
            $service = new AdminBusinessService();
            $job = $service->showJobs();
            //render a response view
            if ($job) {
                return view('displayJobs')->with($job);
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
     * This method is to delete the job post from the database
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function deleteJob() {
        try {
            $this->logger->info("Entering JobPostingController.deleteJob()");
            //GET method for user id
            $id = $_GET['id'];
            //call user business service
            $service = new AdminBusinessService();
            $delete = $service->removeJob($id);
            
            //render a success or fail view
            if($delete) {
                return redirect()->action('JobPostingController@displayAllJobs');
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
     * This method is to find the job post by id
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function findJobPosting() {
        try {
            $this->logger->info("Entering JobPostingController.findJobPosting()");
            //1. process form data
            //get posted form data
            $id = $_GET['id'];
            
            //call security business service
            $service = new AdminBusinessService();
            $jobPosting = $service->findJobPostingByID($id);
            
            //process results from business service (navigation)
            //render a failed or success response view and pass the job posting model to it
            
            if ($jobPosting) {
                return view('editJobPosting')->with('jobPosting', $jobPosting);
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
     * This method is to update the job post info 
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function updateJobPosting(Request $request) {
        try {
            $this->logger->info("Entering JobPostingController.updateJobPosting()");
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);
            
            //recieves data inputed from user
            $id = $request->input('id');
            $jobTitle = $request->input('title');
            $position = $request->input('position');
            $jobDescription = $request->input('jobDescription');
            $employerName = $request->input('companyName');
            $employerCity = $request->input('companyCity');
            $employerState = $request->input('companyState');
            $datePosted = $request->input('datePosted');
            
            //create object model and save posted form data in user object model
            $job = new JobModel($id, $jobTitle, $position, $jobDescription, $employerName, $employerCity, $employerState, $datePosted);
            
            //execute business service and call security business service
            $service = new AdminBusinessService();
            $status = $service->editJobPosting($job);
            
            //process results from business service (navigation)
            //render a failed or redirect to table that displays all jobs
            if ($status) {
                
                return redirect()->action('JobPostingController@displayAllJobs');
            }
            
            else {
                return "Fail";
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
     * This method is to show the job post based on id
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function showJobPosting(Request $request) {
        try {
            $this->logger->info("Entering JobPostingController.showJobPosting()");
            //1. process form data
            //get posted form data
            $id = $request->input('id');
            
            //call security business service
            $service = new AdminBusinessService();
            $jobPosting = $service->findJobPostingByID($id);
            
            //process results from business service (navigation)
            //render a failed or success response view and pass the job posting model to it
            
            if ($jobPosting) {
                return view('jobView')->with('jobPosting', $jobPosting);
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
     * This method is to search for a job post based on keywords in the job title and description
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function searchJob(Request $request){
        try {
            $this->logger->info("Entering JobPostingController.searchJob()");
            //1. process form data
            //get posted form data
            $job = $request->input('search');
            
            //call job posting business service
            $service = new JobPostingBusinessService();
            $jobPost = $service->findJobByName($job);
            
            //returns the results of the search 
            if ($jobPost > 0) {
                return view('searchView')->with('jobPost', $jobPost);
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
    private function validateForm(Request $request){
        //best practice: centralize your rules so you have a consistent architecture and even reuse your rules
        //bad practice: not using a defined data validation framework, putting rules all over your code, doing only on client side or database
        //setup data validation rules for login form
        $rules = ['title' => 'Required | Between:4,50','position' => 'Required | Between:4,50', 'jobDescription' => 'Required | Between:4,100', 'companyName' => 'Required | Between:4,50', 'companyCity' => 'Required | Between:4,50', 'companyState' => 'Required | Between:4,50', 'datePosted' => 'Required'];
        
        //         run data validation rules
        $this->validate($request, $rules);
    }
}