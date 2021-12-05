<?php
session_start();

if(!isset($_SESSION['username'] ) ){
  header("Location:index.php");
}


$all_completed_tasks = [];
$all_non_completed_tasks = [];


$current_user = strval($_SESSION['username']);
$file = 'userdata.json';


try{
  $userData = file_get_contents($file);
  $userTasks = json_decode($userData,true);

  $all_tasks = [];

  foreach ($userTasks as $user => $val) {
    $array = json_decode(json_encode($val), true);
    if ($array['username'] == $current_user ){
     $all_tasks = $userTasks[$user]['content'];
    }
  }

  foreach($all_tasks as $task => $val) {
    $res = json_decode(json_encode($val), true);

    if ($res['completed'] == 1){
      array_push($all_completed_tasks,$res);

    }
    else{
      array_push($all_non_completed_tasks,$res);
    }
  }
}

catch (Exception $e) {
  $all_tasks = [];
}





?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Scheduling Assistant</title>
  <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Ubuntu" rel="stylesheet">

  <!-- Bootstrap Stylesheets  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="showAll.css">


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


  <!-- jquey and ajax Scripts -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  <script type="text/javascript" src="js/tasksApi.js"></script>
  <script type="text/javascript" src="js/taskDisplay.js"></script>

</head>


<body>


    <section class="colored-section" id="title">

    <div class="container-fluid">

      <!-- Nav Bar -->

      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="main.php">TS-Assistant</a>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">

          <ul class="navbar-nav ml-auto">

            <li class="nav-item">
              <a class="nav-link" href="#noncompletedtasks">Non Completed Tasks</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="#completedtasks">Completed Tasks</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="scripts/logout.php">
                  <button class="btn btn-warning"> Logout</button>
                </a>
            </li>

          </ul>

        </div>

      </nav>



    </div>

  </section>


  <section class="white-section" id="noncompletedtasks">

  <div class="container-fluid">



    <div class="row">

      <div class="col-lg-6 col-md-12 col-sm-12">
        <h1>Tasks To Complete</h1>
      </div>




      <?php
      if (count($all_completed_tasks) == 0){
        echo "<div class='col-lg-12 user_tasks'>";
        echo "<center>
        <h4>You don't Have Any Task To Complete.</h4>
        </center>";
        echo "</div>";
      }

      else{


      foreach($all_tasks as $task => $val) {
        $res = json_decode(json_encode($val), true);

        if ($res['completed'] == 0){
        echo "<div class='col-lg-12 user_tasks'>";
        echo "<center>

        <div><a href=\"TaskEdit.php?id=$res[id]\"><button class='btn btn-warning'>Update</button></a> ||
        <a href=\"TaskDelete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\"><button class='btn btn-warning'>Delete</button></a> ||
        <a href=\"TaskComplete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you to mark task as completed?')\"><button class='btn btn-warning'>Mark As Completed</button></a></div>
        </center>
        ";
        echo "<br>";
        echo "<br>";

          echo "<div>";
          echo "<b>".'Title :'."</b>";
              echo "<p>".$res['title']. "</p>";
          echo "</div>";

          echo "<div>";
          echo "<b>".'Description :'."</b>";
              echo "<p>".$res['description']. "</p>";
          echo "</div>";

          echo "<div>";
          echo "<b>".'Time Required :'."</b>";
              echo "<p>".$res['time_required'].' hr'."</p>";
          echo "</div>";

          echo "<div>";
          echo "<b>".'Date :'."</b>";
              echo "<p>".$res['day'].'/'.$res['month'].'/'.$res['year']."</p>";
          echo "</div>";



        echo "</div>";
      }

      }
    }

      ?>

    </div>

  </div>

  </section>




  <section class="white-section" id="completedtasks">

  <div class="container-fluid">



    <div class="row">

      <div class="col-lg-6 col-md-12 col-sm-12">
        <h1>Completed Tasks</h1>
      </div>




      <?php
      if (count($all_non_completed_tasks) == 0){
        echo "<div class='col-lg-12 user_tasks'>";
        echo "<center>
        <h4>You don't Have Completed Any Task.</h4>
        </center>";
        echo "</div>";
      }

      else{


      foreach($all_tasks as $task => $val) {
          $res = json_decode(json_encode($val), true);


          if ($res['completed'] == 1){
        echo "<div class='col-lg-12 user_tasks'>";

          echo "<div>";
          echo "<b>".'Title :'."</b>";
              echo "<p>".$res['title']. "</p>";
          echo "</div>";

          echo "<div>";
          echo "<b>".'Description :'."</b>";
              echo "<p>".$res['description']. "</p>";
          echo "</div>";

          echo "<div>";
          echo "<b>".'Time Required :'."</b>";
              echo "<p>".$res['time_required'].' hr'."</p>";
          echo "</div>";

          echo "<div>";
          echo "<b>".'Date :'."</b>";
              echo "<p>".$res['day'].'/'.$res['month'].'/'.$res['year']."</p>";
          echo "</div>";



        echo "</div>";
      }

      }
    }

      ?>

    </div>

  </div>

  </section>




  </body>

  </html>
