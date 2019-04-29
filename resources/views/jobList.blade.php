<?php session_start();
use App\Services\Business\AdminBusinessService;
?>
@extends('layouts.appmaster')
@section('title', 'Admin Page')

@section('content')

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<table id="user"> 
<h3>Job Listings: </h3>
  <form action="search">
  <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
      <input type="text" placeholder="Search.." name="search">{{ $errors->first('search')}}
      <button type="submit"><i class="fa fa-search"></i></button>
    </form>
<tbody>

<?php 
//user business service is called
$bs = new AdminBusinessService();
$jobs = $bs->showJobs();

//for loop to populate the data table in the displayJobs view
for ($x = 0; $x < count($jobs); $x++) {
    echo "<hr>";

    echo "<u>". $jobs[$x]['JOBTITLE'] . "</u>" . "<br/>";
    echo "Company: " . $jobs[$x]['EMPLOYER'] . "<br/>";
    echo "Date Posted: " . $jobs[$x]['DATE'] . "<br/>";
    echo "<form action='job'><input type='hidden' name='id' value=". $jobs[$x]['ID'] ."><input type='submit' value='More Info'></form>";
}
?>
</table>


@endsection