<?php
namespace App\Http\Controllers;

use App\Services\Utility\MyLogger3;
use Exception;
use App\Models\DTO;
use App\Services\Business\AdminBusinessService;

class JobRestController extends Controller
{
    public function index() {
        try {
            //call service to get all users
            $service = new AdminBusinessService();
            $jobs = $service->showJobs();

            if ($jobs != null) {
                $dto = new DTO(0, "OK", $jobs);
                
                //return json back to caller
                
            }
            else {
                $dto = new DTO(-1, "Job Posts Not Found", "");
            }
            //serialize the dto to JSON
            $json = json_encode($jobs);
            
            return $json;
        }
        
        catch (Exception $e1) {
            //log exception
            MyLogger3::error("Exception: ", array("message" => $e1->getMessage()));
            
            //return an error back to the user in the dto
            $dto = new DTO(-2, $e1->getMessage(), "");
            return json_encode($dto);
        }
    }
    
    public function show($id) {
        try {
            //call service to get all users
            $service = new AdminBusinessService();
            
            $jobs = $service->findJobPostingByID($id);
            
            //create a dto
            if ($jobs == null) {
                $dto = new DTO(-1, "Job Post Not Found", "");
            }
            else {
                $dto = new DTO(0, "OK", $jobs);
            }
            
            //serialize the dto to json
            $json = json_encode($dto);
            
            //return json back to caller
            return $json;
        }
        
        catch (Exception $e1) {
            //log exception
            MyLogger3::error("Exception: ", array("message" => $e1->getMessage()));
            
            //return an error back to the user in the dto
            $dto = new DTO(-2, $e1->getMessage(), "");
            return json_encode($dto);
        }
    }
}