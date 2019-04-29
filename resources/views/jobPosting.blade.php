@extends('layouts.appmaster')
@section('title', 'Job History Page')

@section('content')
<!--- Profile Form --->
	<form action="jobPosting" method="POST" style="background-color: #eaeaea;height: 450px;margin: 0px; width: 600px; border-radius: 10px">
		<input type="hidden" name="_token" value = "<?php echo csrf_token()?>">
	<br>
	
	<br/>
	<h3>Add A Job Posting: </h3>
	<table>
	
	<tr>
	<td><input type="hidden" name="id"/></td>
	</tr>
	
	<tr>
	<td>Job Title:</td>
	<td><input type="text" name="title"/>{{ $errors->first('title')}}</td>
	</tr>
	
	<tr>
	<td>Position:</td>
	<td><input type="text" name="position"/>{{ $errors->first('position')}}</td>
	</tr>
	
	<tr>
	<td>Job Description:</td>
	<td><textarea rows="4" cols="50" name="jobDescription"></textarea>{{ $errors->first('jobDescription')}}</td>
	</tr>
	
	<tr>
	<td>Company Name:</td>
	<td><input type="text" name="companyName"/>{{ $errors->first('companyName')}}</td>
	</tr>
	
	<tr>
	<td>City:</td>
	<td><input type="text" name="companyCity"/>{{ $errors->first('companyCity')}}</td>
	</tr>
	
	<tr>
	<td>State:</td>
	<td><input type="text" name="companyState"/>{{ $errors->first('companyState')}}</td>
	</tr>
	
	<tr>
	<td>Date Posted:</td>
	<td><input type="date" name="datePosted"/>{{ $errors->first('datePosted')}}</td>
	</tr>
	
	<tr>
		<td colspan="2" align="center">
		<input type="submit" value="Submit"/></td>
	</tr> 
	</table>
	</form>
@endsection