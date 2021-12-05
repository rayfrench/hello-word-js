<?php

session_start();

$current_user = strval($_SESSION['username']);
$file = 'userdata.json';

//getting id of the data from url
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
        unset($userTasks[$specific_user]['content'][$task]);
        $userData = json_encode($userTasks);
        


        if (file_put_contents($file, $userData)) {
        } else {
            echo ("<script>alert('Task Not Deleted.')</script>");
        }

      }

    }

  }


catch (Exception $e) {
    echo ("<script>alert('Task Not Deleted')</script>");
}

//redirecting to the display page (index.php in our case)
header("Location:main.php");
header("Refresh:0");
?>
