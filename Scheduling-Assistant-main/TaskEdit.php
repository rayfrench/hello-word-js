<?php

session_start();

$current_user = strval($_SESSION['username']);
$file = 'userdata.json';

if(isset($_POST['update'])){

  $title = $_POST['tasktitle'];
  $description =  $_POST['description'];
  $time_required = $_POST['time_required'];
  $date =  $_POST['date'];
  $orderdate = explode('-', $date);
  $year = $orderdate[0];
  $month   = $orderdate[1];
  $day  = $orderdate[2];


  $id=$_GET['id'];
  try{
    $userData = file_get_contents($file);
    $userTasks = json_decode($userData,true);

    $all_tasks = [];
    $specific_user = "";
    foreach ($userTasks as $user => $val) {
      $array = json_decode(json_encode($val), true);
      if ($array['username'] == $current_user ){
       $all_tasks = $userTasks[$user]['content'];
       $specific_user = $user;
      }
    }

    foreach($all_tasks as $task => $val) {
      $res = json_decode(json_encode($val), true);
        if( $res['id'] == $id ){
          $userTasks[$specific_user]['content'][$task]['title']= $title;
          $userTasks[$specific_user]['content'][$task]['description']= $description;
          $userTasks[$specific_user]['content'][$task]['time_required']= $time_required;
          $userTasks[$specific_user]['content'][$task]['year']= $year;
          $userTasks[$specific_user]['content'][$task]['month']= $month;
          $userTasks[$specific_user]['content'][$task]['day']= $day;


          $userData = json_encode($userTasks);


          if (file_put_contents($file, $userData)) {
          } else {
              echo ("<script>alert('Task Not Updated.')</script>");
              header("Location: main.php");
          }

        }
      }


    }


  catch (Exception $e) {
      echo ("<script>alert('Task Not Updated.')</script>");
      header("Location: main.php");
  }

  header("Location: main.php");





}
?>


<?php
//getting id from url
$id = $_GET['id'];


try{
  $userData = file_get_contents($file);
  $userTasks = json_decode($userData,true);

  $all_tasks = [];
  $specific_user = "";
  foreach ($userTasks as $user => $val) {
    $array = json_decode(json_encode($val), true);
    if ($array['username'] == $current_user ){
     $all_tasks = $userTasks[$user]['content'];
     $specific_user = $user;
    }
  }

  foreach($all_tasks as $task => $val) {
    $res = json_decode(json_encode($val), true);
      if( $res['id'] == $id ){
        $res = $userTasks[$specific_user]['content'][$task];
        $title = $res['title'];
      	$description = $res['description'];
      	$timeRequired = $res['time_required'];
      	$day = $res['day'];
        $month = $res['month'];
        $year = $res['year'];
        $currDate = strval($year)."/".strval($month)."/".strval($day);

      }
    }


  }


catch (Exception $e) {
    echo ("<script>alert('Task Not Marked As Completed.')</script>");
}

?>


<html>
<head>
	<title>Update Data</title>
  <link rel="shortcut icon" type="image/ico" href="./images/favicon.ico"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Ubuntu" rel="stylesheet">

  <!-- CSS Stylesheets -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="main.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

  <!-- Bootstrap Scripts -->


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>




</head>

<body>

  <section class="white-section" id="addnewtask">
    <div class="container-fluid">

   <h1> Update The Task</h1>



  <form id="AddNewTaskForm" method="post" name="AddNewTaskForm"">



      <div class="col-lg-12 task_detais">
          <b>Task Name : </b>
      </div>
      <div class="col-lg-12">
          <input required align="left" placeholder="Enter Task Name" type="text" name="tasktitle" id="tasktitle" value="<?php echo $title;?>"> <br/><br/>
      </div>




      <div class="col-lg-12 task_detais">
          <b>Task Description : </b>
      </div>

      <div class="col-lg-12 ">
        <textarea required type="text" rows="5"  placeholder="Enter Task Description" name="description" id="description" > <?=$description?> </textarea>
          <br><br>
      </div>


      <div class="col-lg-12 task_detais">
          <b>Time Required : </b>
      </div>
      <div class="col-lg-12">
        <input required type="number" name="time_required" id="time_required" placeholder="Enter Task Required Time" min="1" max="9999" value="<?php echo $timeRequired;?>">
          <br><br>
      </div>

      <div class="col-lg-12 task_detais">
          <b>Date: </b>
      </div>
      <div class="col-lg-12">
        <input required type="date" name="date" id="date" value="<?php echo date('Y-m-d',strtotime($currDate)) ?>" >
          <br><br>
      </div>







    <button type="submit" class="btn btn-dark btn-md" name="update" id="update">Submit</button>

  </form>

  </div>

  </section>








</body>
</html>
