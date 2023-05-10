<?php
// DataBase connection
$host = "myprojectdb";
$user = "Pavel";
$pass = "777";
$db_name = "phpProjectDB";
$connection = new mysqli($host, $user, $pass, $db_name);
if ($connection->connect_error) {
    die("connection failed" . $connection->connect_error);
}

// Getting max ID from Students table
function maxID() {

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <title>Random teams</title>
</head>
<body>
<h1>Students list</h1>
<main>
    <div class="studentsList">
      <?php
      // Printing of all students from DB
      $select_query = "SELECT * FROM Students";
      $select_result = mysqli_query($connection, $select_query);
    
      while ($row = mysqli_fetch_assoc($select_result)) {
        foreach ($row as $value) {
          echo ($value) . ". ";
        }
        echo "<br>";
      }
      ?>
    </div>
    
    <div class="forms">
      <form action="index.php" id="addForm" method="POST">
        <lable>Add student</lable>
        <input type="text" name="name" placeholder="John Doe" required/>
        <button type='submit' name="addStudent">Submit</button>
      </form>
      <form action="index.php" id="deleteForm" method="POST">
        <lable>Delete by id</lable>
        <input type="number" name="id" placeholder="12" required/>
        <button type='submit' name="deleteStudent">Delete</button>
      </form>
    </div>
    
    <div class="">
      <?php
      // ADD STUDENT
      if (isset($_POST["addStudent"])) {
        // define amount of students
        $select_query = "SELECT MAX(id) FROM Students";
        $select_answer = mysqli_query($connection, $select_query);
        $maxId = mysqli_fetch_assoc($select_answer);
        $maxId = intval($maxId["MAX(id)"]);
        $id = $maxId + 1; // new student's id
        // Inserting student to DB an Student list
        $addedName = $_POST["name"];
        $insert_query = "INSERT INTO `Students` (id, name) VALUES('$id', '$addedName')";
        $insert_result = mysqli_query($connection, $insert_query);
        // to clear $_POST variable and input data:
        unset($_POST);
        echo '<meta http-equiv="refresh" content="0">';
      }
  
      // DELETE STUDENT
      if (isset($_POST["deleteStudent"])) {
        // Inserting student to DB an Student list
        $deletingID = $_POST["id"];
        $delete_query = "DELETE FROM Students WHERE id='$deletingID'";
        $delete_result = mysqli_query($connection, $delete_query);
        // to clear $_POST variable and input data:
        unset($_POST);
        echo '<meta http-equiv="refresh" content="0">';
      }


      ?>
    </div>
</main>

</body>
</html>