<?php
//Emily Quevedo
//February 28, 2019
//This is my own work

/* Skills controller handles user skills methods */

namespace App\Http\Controllers;

use Exception;
use App\Services\Business\ProfileBusinessService;
use App\Models\SkillsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SkillsController extends Controller {

    /**
     * This method is to find the user's skills
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory|boolean
     */
    public function findSkills() {
        try {
            //get posted form data
            $id = session()->get('user_id');
            
            //call business service
            $service = new ProfileBusinessService();
            $skills = $service->findSkillsByID($id);
            
            //render a failed or edit skills view and pass the skills model to it
            if ($skills) {
                return view('editSkills')->with('skills', $skills);
            }
            
            else {
                return false;
            }
        }
        
        catch (Exception $e){
            //best practice: call all exceptions, log the exception, and display a common error page (or use a global exception handler)
            //log exception and display exception view
            Log::error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    //method to create user skills
    /**
     * This method allows the user to insert their skills
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createSkills(Request $request) {
        try {
            //validate the form date
            //view if errors
            $this->validateForm($request);
            
            //get posted form data
            $skill = $request->input('skills');
            
            if ($request->session()->has('user_id')) {
                $user_id = $request->session()->get('user_id');
            }
            
            //create object model and save posted form data in skills object model
            $skills = new SkillsModel(-1, $skill, $user_id);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->addSkills($skills);
            
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
            Log::error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    //update skill
    /**
     * This method is to update the user's skill info
     * @param Request $request
     * @throws ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSkill(Request $request) {
        try {
            //validate the form date (note will automatically redirect back to login
            //view if errors
            $this->validateForm($request);
            
            //get posted form data
            $id = $request->input('id');
            $skill = $request->input('skills');
            
            //create object model and save posted form data in skill object model
            $userSkill = new SkillsModel($id, $skill, 0);
            
            //execute business service and call security business service
            $service = new ProfileBusinessService();
            $status = $service->editSkills($userSkill);
            
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
            Log::error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    //method to delete skill
    /**
     * This method is to delete the skill
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSkill() {
        try {
            //GET method for user id
            $id = $_GET['id'];
            //call user business service
            $service = new ProfileBusinessService();
            $delete = $service->removeSkill($id);
            
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
            Log::error("Exception: ", array("message" => $e->getMessage()));
            $data = ['errorMsg' => $e->getMessage()];
            return view('exception')->with($data);
        }
    }
    
    private function validateForm(Request $request){
        //best practice: centralize your rules so you have a consistent architecture and even reuse your rules
        //bad practice: not using a defined data validation framework, putting rules all over your code, doing only on client side or database
        //setup data validation rules for login form
        $rules = ['skills' => 'Required | Between:2,50'];
        
        //         run data validation rules
                 $this->validate($request, $rules);
    }
}