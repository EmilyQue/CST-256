<?php session_start();
use App\Services\Business\AdminBusinessService;
?>
@extends('layouts.appmaster')
@section('title', 'Admin Page')

@section('content')

<head>
<style>
#user {
    font-family: "Comic Sans", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#user td, #user th {
    border: 1px solid #ddd;
    padding: 8px;
}

#user tr:nth-child(even) {
    background-color: #f2f2f2;
}

#user tr:hover {
    background-color: #ddd;
}

#user th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #7554ba;
    color: white;
}

#user thead {
    background-color: #aabd8c;
}
</style>

</head>
<table id="user"> 
<thead>
	<th>Delete</th>
	<th>Edit</th>
	<th>ID</th>
	<th>Group Name</th>
	<th>Description</th>
	</thead>
<tbody>

<?php 
//user business service is called
$bs = new AdminBusinessService();
$groups = $bs->showGroups();

//for loop to populate the data table in the displayUsers view
for ($x = 0; $x < count($groups); $x++) {
    echo "<tr>";
    
    echo "<td><form action='groupDelete'><input type='hidden' name='id' value=". $groups[$x]['ID'] ."><input type='submit' value='Delete'></form>  </td>";
    echo "<td><form action='groupEdit'><input type='hidden' name='id' value=". $groups[$x]['ID'] ."><input type='submit' value='Edit'></form>  </td>";
    
    echo "<td>" . $groups[$x]['ID'] . "</td>";
    echo "<td>" . $groups[$x]['NAME'] . "</td>";
    echo "<td>" . $groups[$x]['DESCRIPTION'] . "</td>";
}
?>
</table>
<!-- //loops through person array and prints values -->

@endsection