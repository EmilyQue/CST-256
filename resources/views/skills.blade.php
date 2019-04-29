@extends('layouts.appmaster')
@section('title', 'Skills Page')

@section('content')
<!--- Profile Form --->
	<form action="skills" method="POST" style="background-color: #eaeaea;height: 250px;margin: 0px; width: 600px; border-radius: 10px">
		<input type="hidden" name="_token" value = "<?php echo csrf_token()?>">
	<br>
	
	<br/>
	<h3>Add Skills: </h3>
	<table>
	
	<tr>
	<td><input type="hidden" name="users_id"/></td>
	</tr>
	
	<tr>
	<td>Skills:</td>
	<td><input type="text" name="skills"/>{{ $errors->first('skills')}}</td>
	</tr>
	
	<tr>
		<td colspan="2" align="center">
		<input type="submit" value="Submit"/></td>
	</tr> 
	</table>
	</form>
@endsection