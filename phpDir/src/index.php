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

  // Getting max ID from table "Students"
  function maxID() {
    global $connection;

    $select_query = "SELECT MAX(id) FROM Students";
    $select_answer = mysqli_query($connection, $select_query);
    $maxId = mysqli_fetch_assoc($select_answer);
    $maxId = intval($maxId["MAX(id)"]);

    return $maxId;
  }

  // ADD STUDENT
  if (isset($_POST["addStudent"])) {
    $id = maxId() + 1; // new student's id
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
    $maxID = maxID();
    $delete_query = "DELETE FROM Students WHERE id='$deletingID'";
    $delete_result = mysqli_query($connection, $delete_query);

    // Changing all student's id after id of deleted student
    for ($id = $deletingID + 1; $id <= $maxID; $id++) {
      $update_query = "UPDATE Students SET id=id-1 WHERE id='$id'";
      $update_result = mysqli_query($connection, $update_query);
    }

    // to clear $_POST variable and input data:
    unset($_POST);
    echo '<meta http-equiv="refresh" content="0">';
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
      // Printing all students from DB
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
    <div class="rightSide">
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
        <form action="index.php" id="howManyForm" method="POST">
          <lable>Students per team</lable>
          <input type="number" name="howManyStudents" required/>
          <button type='submit' name="divideStudents">Divide</button>
        </form>
      </div>
      <div class="teamsOutput">
        <?php
           //DIVIDE STUDENTS BY TEAMS
          if (isset($_POST["divideStudents"])) {
            $team_size = $_POST['howManyStudents'];
            $number_of_students = maxID();
            if ($team_size < 2 || $number_of_students - $team_size < 2) {
              echo '<h1>Dividing doesn\'t make sense</h1>';
            } else {
              $students_array = range(1, $number_of_students); // [1, 2, 3, ... , maxID]
              $team_number = 1;
              while (count($students_array) > $team_size + 1) {
                echo "<div class='team'><h2>Team $team_number</h2><div class='names'>";
                  for ($i = 1; $i <= $team_size; $i++){
                    $randomNumber = rand(1, $number_of_students);

                  }
                echo "</div></div>";
                exit;
              }
              // to clear $_POST variable and input data:
              unset($_POST);
              echo '<meta http-equiv="refresh" content="0">';
            }
          }
        ?>
      </div>
    </div>
</main>

</body>
</html>