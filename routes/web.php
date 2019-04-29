<?php
//Milestone 1
//Login Module
//Emily Quevedo
//January 20, 2019
//This is my own work

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

/*Route is mapped to the '/register' URI and will return the Register view */
Route::get('/register', function() {
    return view('register');
});
        
/*Fetches the post parameters of registration*/
Route::post('/register', 'RegistrationController@index');
      
/*Route is mapped to the '/login' URI and will return the Login view */
Route::get('login', function () {
    return view('login');
        });
      
/*Fetches the post parameters of login*/
Route::post('/login', 'LoginController@index');

Route::get('/logout', 'LoginController@logout');

/*temporary route that is mapped to the '/start' URI and will return the job list view*/
Route::get('start', function() {
    return view('jobList');
});
        
/* Route is mapped to the '/profile' URI and will return the user Profile view*/
Route::get('/profile', 'ProfileController@findProfile');


/*  USER CONTACT INFO   */
/*Route is mapped to the '/contact' URI and will return the contact info form*/
Route::get('/contact', function() {
    return view('contact');
});
    
/*Fetches the post parameters of user contact info*/
Route::post('/contact', 'ProfileController@createContactInfo');

/*Route is mapped to the '/editContact' URI and will return the edit contact info form */
Route::get('/editContact', 'ProfileController@findContactInfo');

/*Fetches the post parameters of updated user contact info*/
Route::post('/updateContact', 'ProfileController@updateContactInfo');

/*Fetches the get parameters of deleteContact method in Profile controller*/
Route::get('/deleteContact', 'ProfileController@deleteContact');


/*  USER EDUCATION   */
/*Route is mapped to the 'education' URI and will return new education form*/
Route::get('/education', function() {
    return view('education');
});

/*Fetches post parameters of new education*/
Route::post('education', 'EducationController@createEducation');
    
/*Route is mapped to the 'editEducation' URI and will return edit education form*/
Route::get('/editEducation', 'EducationController@findEducation');

/*Fetches post parameters of updated user education*/
Route::post('updateEducation', 'EducationController@updateEducation');

/*Fetches get parameters of deleteEducation method in Profile controller*/
Route::get('/deleteEducation', 'EducationController@deleteEducation');


/*  USER SKILLS   */
/*Route is mapped to the 'skills' URI and will return new skills form*/
Route::get('/skills', function() {
    return view('skills');
});
    
/*Fetches post parameters of new skills*/
Route::post('skills', 'SkillsController@createSkills');
    
/*Route is mapped to the 'editSkills' URI and will return edit skills form */
Route::get('/editSkills', 'SkillsController@findSkills');

/*Route is mapped to the 'updateSkills' URI and will return a form to edit skills*/
Route::get('/updateSkills', function() {
    return view('editSkills');
});
    
/*Fetches post parameters of updated skills*/
Route::post('/updateSkills', 'SkillsController@updateSkill');

/*Fetches get parameters of deleteSkill method in Profile controller*/
Route::get('/deleteSkills', 'SkillsController@deleteSkill');


/*  USER JOB HISTORY  */
/*Route is mapped to the 'jobHistory' URI and returns the job history form */
Route::get('/jobHistory', function() {
    return view('jobhistory');
});

/*Fetches post parameters of new job history */
Route::post('/jobHistory', 'JobHistoryController@createJobHistory');

/*Route is mapped to the 'editHistory' URI and will return edit job history form*/
Route::get('/editHistory', 'JobHistoryController@findJobHistory');

/*Fetches post parameters of updated job history*/
Route::post('/updateHistory', 'JobHistoryController@updateJobHistory');

/*Fetches get parameters of deleteHistory method in Profile controller*/
Route::get('/deleteHistory', 'JobHistoryController@deleteJobHistory');


/*  USER AFFINITY GROUPS   */
/*Route is mapped to the 'groupList' URI and will return the group view*/
Route::get('groupList', function() {
    return view('groupList');
});

/*Fetches the get parameters of show group by id method in profile controller*/
Route::get('groupView', 'ProfileController@showGroupByID');

/*Fetches the get parameters of join group method in profile controller*/
Route::get('joinGroup', 'ProfileController@joinGroup');

/*Fetches the get parameters of leave group method in profile controller*/
Route::get('/leaveGroup', 'ProfileController@leaveGroup');

/*Fetches the get parameters of show group members method in profile controller*/
Route::get('userGroup', 'ProfileController@showGroupMembers');

/*  USER JOB APPLICATION   */
/*Fetches the get parameters of each job posting and displays info from each individual job post*/
Route::get('/job', 'JobPostingController@showJobPosting');

/*Fetches the get paramters of apply to job method in profile controller*/
Route::get('/applyJob', 'ProfileController@applyToJob');

/*Fetches the get parameters of search job method in job posting controller*/
Route::get('/search', 'JobPostingController@searchJob');

/*  ADMIN AFFINITY GROUPS   */
/*Route is mapped to the 'groups' URI and will return the create group form*/
Route::get('/groups', function() {
    return view('groups');
});

/*Fetches post parameters of new group created*/
Route::post('/groups', 'AdminController@addGroup');

/*Fetches the get parameters of groups admin*/
Route::get('/groupsAdmin', 'AdminController@displayAllGroups');

/*Fetches the get parameters of deleteGroup method in Admin controller*/
Route::get('/groupDelete', 'AdminController@deleteGroup');

/*Fetches the get parameters of findGroup method in Admin controller*/
Route::get('/groupEdit', 'AdminController@findGroup');

/*Fetches the post parameters of updateGroup method in Admin controller*/
Route::post('/groupUpdate', 'AdminController@updateGroup');


/*  ADMIN JOB POSTING   */
/*Route is mapped to the 'jobPosting' URI and will return the job post form*/
Route::get('jobPosting', function() {
    return view('jobPosting');
});

/*Fetches post parameters of new job posting*/
Route::post('jobPosting', 'JobPostingController@addJobPosting');

/*Fetches the get parameters of job post admin*/
Route::get('/jobAdmin', 'JobPostingController@displayAllJobs');

/*Fetches the get parameters of jobDelete method in Admin controller*/
Route::get('/jobDelete', 'JobPostingController@deleteJob');

/*Fetches the get parameters of jobEdit method in Admin controller*/
Route::get('/jobEdit', 'JobPostingController@findJobPosting');

/*Fetches the post parameters of jobUpdate method in Admin controller*/
Route::post('/jobUpdate', 'JobPostingController@updateJobPosting');

/*  ADMIN USERS   */
/*Fetches the get parameters of users admin*/
Route::get('/usersAdmin', 'AdminController@index');

/*Fetches the get parameters of deleteUser method in the Admin controller*/
Route::get('/adminDelete', 'AdminController@deleteUser');

/*Fetches the get parameters of suspendUser method in the Admin controller*/
Route::get('/adminSuspend', 'AdminController@suspendUser');

/*Fetches the get parameters of unsuspendUser method in the Admin controller*/
Route::get('/adminUnsuspend', 'AdminController@unsuspendUser');

/*  JOB POSTS RESTful SERVICE   */
Route::resource('/jobsrest', 'JobRestController');

/*  PROFILE RESTful SERVICE   */
Route::resource('/profilerest', 'ProfileRestController');

