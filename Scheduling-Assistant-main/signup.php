<?php
session_start();

if(isset($_SESSION['username'] ) ){
  header("Location:main.php");
}

if(isset($_POST['register'])){
  $registerusername = $_POST['registerusername'];
  $registerpassword = md5($_POST['registerpassword']);
  $file = 'userdata.json';
  $counter = 0;


  try{
    $fileData = file_get_contents($file);
    $arrayData = json_decode($fileData);

    if ($arrayData == null) {
        $arrayData = array();
    }
    else{

      foreach ($arrayData as $user => $val) {
        $array = json_decode(json_encode($val), true);
        if ($array['username'] == $registerusername ){
          $counter = $counter + 1;
          echo ("<script>alert('User Name Alreday Exist. Please Choose Another User Name')</script>");
        }
      }
    }

    if ($counter == 0){
      $userTasks = array();
      $newUser = array('username' => $registerusername,
                          'password' => $registerpassword,
                          'content' => $userTasks);

      array_push($arrayData, $newUser);
      $fileData = json_encode($arrayData);

      if (file_put_contents($file, $fileData)) {
          echo ("<script>alert('User Created Successfully')</script>");
          $registerusername="";
          $_POST['registerpassword']="";
          header("Location:index.php");
      } else {
          echo ("<script>alert('User Not Created')</script>");
      }

    }



  } catch (Exception $e) {
      echo ("<script>alert('User Not Created')</script>");
  }



}


 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sign Up</title>

    <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat|Ubuntu" rel="stylesheet">
  <link rel="shortcut icon" type="image/ico" href="images/favicon.ico"/>
  <!-- CSS Stylesheets -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">

  <!-- Font Awesome -->
  <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>



  <!-- Bootstrap Scripts -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


  </head>
  <body>

    <div class="container">
      <div class="myCard">
        <div class="row">
          <div class="col-md-12 ">
            <div class="myLeftCtn">
              <form class="myForm text-center" action="" method="post">
                <header>CREATE NEW ACCOUNT</header>
                <div class="form-group">
                  <i class="fas fa-user"></i>
                  <input type="text" placeholder="Username" class="myInput" id="username" name="registerusername" required>
                </div>


                <div class="form-group">
                  <i class="fas fa-envelop"></i>
                  <input type="password" class="myInput" placeholder="Password" id="password" name="registerpassword" required>

                </div>

                <input type="submit" class="butt" value="signup" name="register">

              </form>

              <div class="register">
                <h7>Have an Account ? <a href="index.php">Login Here</a>
                </h7>

              </div>

            </div>
          </div>
        </div>

      </div>

    </div>


  </body>
</html>
