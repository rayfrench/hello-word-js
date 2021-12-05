<?php
  $databaseserver="localhost";
  $databaseusername="root";
  $databasepassword="";
  $databasename="schedulingAssistant";

  $conn=mysqli_connect($databaseserver,$databaseusername,$databasepassword,$databasename);

  if(!$conn){
    echo ("<script>alert('Connection Not Established')</script>");
  }

 ?>
