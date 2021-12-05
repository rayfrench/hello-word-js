function mouseOver(projectID) {
  console.log(projectID);
  document.getElementById("project1").style.color = "#63ca00";
  document.getElementById("project1").innerHTML =
  "Example title<br>A project.<br>10 hours to completion";
}
function mouseOut() {
  document.getElementById("project1").style.color = "black";
  document.getElementById("project1").innerHTML =
  "1<br>Example Title";
}
function displayTask(taskNumber) {
  taskInfo = getTasks()[taskNumber];
  title = taskInfo.title;
  timeRequired = taskInfo.time_required;
  desc = taskInfo.description;
  date = taskInfo.date;
  day = date.charAt(8);
  projectID = "project2"

  selectedDay = document.getElementById("calendar").getElementsByTagName("li")[parseInt(day)];
  selectedDay.innerHTML = parseInt(day)+1+"<br>"+title+"<br>"+desc+"<br>"+timeRequired+" hours to completion";
  selectedDay.onmouseover = "mouseOver(project2)";
  selectedDay.onmouseout = "mouseOut(project2)";
  selectedDay.id = "project2";
  //todo:update mouseOver() and mouseOut()
}
function displayAllTasks() {
  taskList = getTasks();
  console.log(taskList);
  for (i in taskList) {
    title = taskList[i].title;
    timeRequired = taskList[i].time_required;
    desc = taskList[i].description;
    date = taskList[i].date;
    if (date.charAt(8) == "0")
      day = parseInt(date.charAt(9));
    else
      day = parseInt(date.charAt(8)+date.charAt(9));

    selectedDay = document.getElementById("calendar").getElementsByTagName("li")[day-1];
    if (desc != "") {
      selectedDay.innerHTML = day+"<br>"+title+"<br>"+desc+"<br>"+timeRequired+" hours left";
    }
    else
    selectedDay.innerHTML = day+"<br>"+title+"<br>"+timeRequired+" hours left<br><br>";
  }
}
