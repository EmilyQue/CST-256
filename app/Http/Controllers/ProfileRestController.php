<?php
namespace App\Http\Controllers;

use App\Services\Utility\MyLogger3;
use Exception;
use App\Models\DTO;
use App\Services\Business\ProfileBusinessService;

class ProfileRestController extends Controller
{
    public function index() {
       //
    }
    
    public function show($id) {
        try {
            //call service to get all users
            $service = new ProfileBusinessService();

            $contact = $service->findContactByID($id);
            $skills = $service->findSkillsByID($id);
            $education = $service->findEducationByID($id);
            $history = $service->findJobHistoryByID($id);
            
            $profile = [$contact, $skills, $education, $history];
            
            //create a dto
            if ($contact == null && $skills == null && $education == null && $history == null) {
                $dto = new DTO(-1, "User Profile Was Not Found", "");
            }
            else {
                $dto = new DTO(0, "OK", $profile);
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