<?php
// This file returns a JSON encoded array as a result

    header('Access-Control-Allow-Origin: *');
    
    // This is where the code begins execution
    if (!isset($_POST['action'])) {
        $result = array('error' => 'There is no action in the given request.');
        echo json_encode($result);
        return;
    }

    // Each POST request should have an action
    // The 'add' action is for adding a new task. This requires:
    // Timestamp, day, month, year, time_required, title, and description
    if ($_POST['action'] == 'add') {

        // If there are missing variables, return an error
        if (!isset($_POST['timestamp']) || !isset($_POST['date']) ||
            !isset($_POST['time_required']) || !isset($_POST['title']) || !isset($_POST['description'])) {
                $result = array('error' => 'There are missing variables.');
                echo json_encode($result);
                return;
        }

        addTask($_POST['timestamp'], $_POST['date'], $_POST['time_required'], $_POST['title'], $_POST['description']);
    }

    // The 'getTasks' action is for retrieving all of the tasks as a JSON array
    if ($_POST['action'] == 'getTasks') {
        getTasks();
    }
    
    // Add a new task to the JSON file. Return a success message, or an error
    function addTask($timestamp, $date, $timeRequired, $title, $description) {

        $file = "data.json";

        try {
            // Get the file contents and convert it to JSON

            $fileData = file_get_contents($file);
            $arrayData = json_decode($fileData, true);

            // If there is no data present, create a new array
            if ($arrayData == null) {
                $arrayData = array();
            }

            // Create the new task array
            $newTask = array('timestamp' => $timestamp, 
                                'date' => $date,
                                'time_required' => $timeRequired,
                                'title' => $title,
                                'description' => $description);

            // Add the new task into the array then encode it into JSON
            array_push($arrayData, $newTask);
            $fileData = json_encode($arrayData);

            // Attempt to replace the contents of the file with the added task
            if (file_put_contents($file, $fileData)) {
                $result = array('message' => 'Task added successfully!');
                echo json_encode($result);
            } else {
                $result = array('error' => 'Task could not be added.');
                echo json_encode($result);
            }
        } catch (Exception $e) {
            $result = array('error' => 'Task could not be added.');
            echo json_encode($result);
        }
    }

    // Return all of the tasks in the JSON file, or an error
    function getTasks() {

        $file = "data.json";
        
        try {
            $fileData = file_get_contents($file);
            $arrayData = json_decode($fileData, true);

            // Should fix an error that happens when there aren't any tasks
            if ($arrayData == null) {
                $arrayData = array();
            }

            $result = array('tasks' => $arrayData);
            echo json_encode($result);
        } catch (Exception $e) {
            $result = array('error' => 'Tasks could not be retrieved.');
            echo json_encode($result);
        }
    }
?>