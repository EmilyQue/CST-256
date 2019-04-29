<?php session_start();
use App\Services\Business\AdminBusinessService;
?>
@extends('layouts.appmaster')
@section('title', 'Groups Page')

@section('content')

<head>
<style>
#user {
    font-family: "Comic Sans", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 70%;
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
	<th>Group Name</th>
	<th>More Info</th>
	</thead>
<tbody>

<?php 
$bs = new AdminBusinessService();
$group = $bs->showGroups();

//for loop to populate the data table in the displayJobs view
for ($x = 0; $x < count($group); $x++) {
    echo "<tr>";
    echo "<td>" . $group[$x]['NAME'] . "</td>";
    echo "<td><form action='groupView'><input type='hidden' name='id' value=". $group[$x]['ID'] ."><input type='submit' value='More Info'></form></td>";
}
?>
</table>
<!-- //loops through person array and prints values -->

@endsection