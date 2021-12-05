// Add jQuery as a script
var jqueryScript = document.createElement('script');
jqueryScript.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
jqueryScript.type = 'text/javascript';
document.getElementsByTagName('head')[0].appendChild(jqueryScript);

// Send an AJAX request to main.php to add a new task
// into the JSON document
function addTask() {
    var action = 'add';
    var timestamp = Date.now();
    var date = document.getElementById('date').value;
    var time_required = document.getElementById('time_required').value;
    var title = document.getElementById('title').value;
    var description = document.getElementById('description').value;

    // Make an AJAX request to create a new task
    $.post("php/tasks.php",
        {
            action,
            timestamp,
            date,
            time_required,
            title,
            description
        },
        function (data) {
            // data holds the resulting data from the php
            var resultObj = JSON.parse(data);
            console.log(resultObj);

            // There will either be an error or a success message
            if (resultObj.error != null) {
                console.log(resultObj.error);
                alert(resultObj.error);
            } else {
                fetchTasks();
                alert(resultObj.message);
            }
        });

    // Stops the web-page from redirecting
    return false;
}

// fetches the tasks from the backend and stores the result using storeTasks
function fetchTasks() {
    var action = 'getTasks';

    $.ajax({
        url: 'php/tasks.php',
        type: 'POST',
        data: { action },
        success: function (data) {
            var resultObj = JSON.parse(data);

            // There is either an error or a tasks property
            if (resultObj.error != null) {
                alert(resultObj.error);
                console.log(resultObj.error);
            } else {
                var tasks = resultObj.tasks;
                console.log(tasks);
                storeTasks(tasks);
                displayAllTasks();
            }
        }
    });

    return false;
}

// Handles the fetchTasks ajax result data by setting tasks in local storage
function storeTasks(tasks) {
    localStorage.setItem('tasks', JSON.stringify(tasks));
}

// Fetches and returns all of the tasks in the local storage
function getTasks() {
    fetchTasks();
    var tasksString = localStorage.getItem('tasks');
    return JSON.parse(tasksString);
}
