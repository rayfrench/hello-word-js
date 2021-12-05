<?php
session_start();

if(isset($_SESSION['username'] ) ){
  header("Location:main.php");
}

if(isset($_POST['login'])){
  $loginusername = $_POST['loginusername'];
  $loginpassword = md5($_POST['loginpassword']);

  $file = 'userdata.json';
  $counter = 0;

  try{
    $fileData = file_get_contents($file);
    $arrayData = json_decode($fileData);


    if ($arrayData == null) {
        echo ("<script>alert('Email or Password is Wrong')</script>");
    }
    else{
      foreach ($arrayData as $user => $val) {
        $array = json_decode(json_encode($val), true);
        if ($array['username'] == $loginusername and $array['password'] == $loginpassword){
          $counter = $counter + 1;
          $_SESSION['username']=$array['username'];
          header("Location:main.php");

        }
      }
    }

    if ($counter  == 0){
      echo ("<script>alert('Email or Password is Wrong')</script>");

    }

  }
  catch (Exception $e) {
      echo ("<script>alert('Invalid Login')</script>");
  }




}




 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sign In</title>

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
              <form class="myForm text-center" method="post" action="">
                <header>ENTER ACCOUNT CREDENTIALS</header>
                <div class="form-group">
                  <i class="fas fa-user"></i>
                  <input type="text" placeholder="Username" class="myInput" id="username" name="loginusername" required>
                </div>


                <div class="form-group">
                  <i class="fas fa-envelop"></i>
                  <input type="password" class="myInput" placeholder="Password" id="password" name="loginpassword" required>

                </div>

                <input type="submit" class="butt" name="login">

              </form>

              <div class="register">
                <h7>Don't have an Account ? <a href="signup.php">Register Here</a>
                </h7>

              </div>

            </div>
          </div>
        </div>

      </div>

    </div>


  </body>
</html>
