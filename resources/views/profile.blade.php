@extends('layouts.appmaster')
@section('title', 'Profile Page')

@section('content')
<body>
        <div class="profile-header-container">   
    		<div class="profile-header-img">
                <img class="img-circle" src="resources/assets/blank-user.jpg" />
                <div class="rank-label-container">
                    <span class="label label-default rank-label">Profile</span>
                </div>
            </div>
        </div> 
    </body>
    
    
<h3>Contact Info: </h3>
@if(count($contactInfo) != 0) 
		@foreach($contactInfo as $c)
			Business Email: {{$c->getBusinessEmail()}} <br/>
			Phone Number: {{$c->getPhone()}} <br/>
			About Me: {{$c->getAboutMe()}} <br/>
			Street Address: {{$c->getStreetAddress()}} <br/>
			City: {{$c->getCity()}} <br/>
			State: {{$c->getState()}} <br/>
			Zipcode: {{$c->getZipcode()}} <br/>
		@endforeach
		    <td><form action='editContact'><input type='hidden' name='id' value={{$c->getId()}}><input type='submit' value='Edit'></form>  </td>
    <td><form action='deleteContact'><input type='hidden' name='id' value={{$c->getId()}}><input type='submit' value='Delete'></form>  </td>
	@else
	<a href="contact">Add Contact</a><br/>
	@endif

	<hr>
	<h3>Education: </h3>
	@if(count($education) != 0) 
		@foreach($education as $e)
			<u>{{$e->getDegree()}}</u> <br/>
			School: {{$e->getSchoolName()}} <br/>
			Location: {{$e->getCity()}}, {{$e->getState()}} <br/>
			Year Graduated: {{$e->getGraduationYear()}} <br/>
	<td><form action='editEducation'><input type='hidden' name='id' value={{$e->getId()}}><input type='submit' value='Edit'></form>  </td>
    <td><form action='deleteEducation'><input type='hidden' name='id' value={{$e->getId()}}><input type='submit' value='Delete'></form>  </td>
		@endforeach
	@endif
	<a href="education">Add Education</a><br/>
	<hr>
	<h3>Job History: </h3>
	@if(count($history) != 0) 
		@foreach($history as $job)
			Previous Job Title: {{$job->getPreviousJobTitle()}} <br/>
			Description: {{$job->getPreviousJobDescription()}} <br/>
			Start Date: {{$job->getStartDate()}} <br/>
			End Date: {{$job->getEndDate()}} <br/>
			Company: {{$job->getCompanyName()}} <br/>
			Location: {{$job->getCity()}}, {{$job->getState()}} <br/>
	<td><form action='editHistory'><input type='hidden' name='id' value={{$job->getId()}}><input type='submit' value='Edit'></form>  </td>
    <td><form action='deleteHistory'><input type='hidden' name='id' value={{$job->getId()}}><input type='submit' value='Delete'></form>  </td>
		@endforeach
	@endif
	<a href="jobHistory">Add Job History</a><br/>
	<hr>
	<h3>Skills: </h3>
	@if(count($skills) != 0) 
		@foreach($skills as $skill)
			Skill: {{$skill->getUserSkill()}} <br/>
	<td><form action='editSkills'><input type='hidden' name='id' value={{$skill->getId()}}><input type='submit' value='Edit'></form>  </td>
    <td><form action='deleteSkills'><input type='hidden' name='id' value={{$skill->getId()}}><input type='submit' value='Delete'></form>  </td>
		@endforeach
	@endif	
	<a href="skills">Add Skills</a><br/>
	<hr>
@endsection