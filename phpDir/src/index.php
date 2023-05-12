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

  // Gets max ID from table "Students"
  function maxID() {
    global $connection;

    $select_query = "SELECT MAX(id) FROM Students";
    $select_answer = mysqli_query($connection, $select_query);
    $maxId = mysqli_fetch_assoc($select_answer);
    $maxId = intval($maxId["MAX(id)"]);

    return $maxId;
  }

  // ADDS STUDENT
  if (isset($_POST["addStudent"])) {
    $id = maxId() + 1; // new student's id
    // Inserts student to DB an Student list
    $addedName = $_POST["name"];
    $addedName = str_replace("'","''",$addedName); //sanitizing from " ' "
    $insert_query = "INSERT INTO `Students` (id, name) VALUES('$id', '$addedName')";
    $insert_result = mysqli_query($connection, $insert_query);
    // Clears $_POST variable and input data (it prevents new adding when page refreshed):
    unset($_POST);
    echo '<meta http-equiv="refresh" content="0">';
  }

  // DELETES STUDENT
  if (isset($_POST["deleteStudent"])) {

    // Inserts student to DB and Student list
    $deletingID = $_POST["id"];
    $maxID = maxID();
    $delete_query = "DELETE FROM Students WHERE id='$deletingID'";
    $delete_result = mysqli_query($connection, $delete_query);

    // Changes all student's ids that goes after deleted student's id
    for ($id = $deletingID + 1; $id <= $maxID; $id++) {
      $update_query = "UPDATE Students SET id=id-1 WHERE id='$id'";
      $update_result = mysqli_query($connection, $update_query);
    }

    // Clears $_POST variable and input data (it prevents new deleting when page refreshed):
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="index.css">
  <title>Random teams</title>
</head>
<body>
  <div>
    <header><h1>STUDENTS |&#8592; &nbsp;&nbsp; &rarr;| DIVIDER</h1></header>
    <main>
      <div class="studentsList">
        <h2>Students list</h2>
        <?php
        // Prints all students from DB
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
          <div>
            <input type="text" name="name" placeholder="John Doe" required/>
            <button type='submit' name="addStudent">Submit</button>
          </div>
        </form>
        <form action="index.php" id="deleteForm" method="POST">
          <lable>Delete student by id</lable>
          <div>
            <input type="number" name="id" placeholder="12" required/>
            <button type='submit' name="deleteStudent">Delete</button>
          </div>
        </form>
        <form action="index.php" id="howManyForm" method="POST">
          <lable>Students per team</lable>
          <div>
            <input type="number" name="howManyStudents" required/>
            <button type='submit' name="divideStudents">Divide</button>
          </div>
        </form>
      </div>
      <div class="teamsOutput">
        <?php
            //DIVIDES STUDENTS BY TEAMS
          if (isset($_POST["divideStudents"])) {
            $team_size = $_POST['howManyStudents'];
            $number_of_students = maxID();
            if ($team_size < 2 || $number_of_students - $team_size < 2) {
              echo '<h1>Dividing doesn\'t make sense</h1>';
            } else {
  
              $students_array = range(1, $number_of_students); // [1, 2, 3, ... , maxID]
              $team_number = 1;
              while (count($students_array) > $team_size + 1) {
                echo "<div class='team' style='display:none;'><h2>Team $team_number</h2><div class='names'>";
                  for ($i = 1; $i <= $team_size; $i++){
                    $random_number = rand(0, count($students_array) - 1);
                    $random_students_id = $students_array[$random_number]; //chooses random student's id
                    
                    //Takes the name of that random student from DB
                    $query = "SELECT * FROM Students WHERE id='$random_students_id'";
                    $query_result = mysqli_query($connection, $query);
                    $random_student = mysqli_fetch_row($query_result)[1];
                    
                    echo "<p>$i. $random_student</p>"; //prints that random student in current team
                    unset($students_array[$random_number]); //deletes that random student from array
                    $students_array = \array_values($students_array); //resets the indexes (keys) of array after deleting element (stupid PHP!)
                  }
                echo "</div></div>";
                $team_number++;
              }
              //Outputs the last Team (if exist)
              $i=1;
              echo "<div class='team' style='display:none;'><h2>Team $team_number</h2><div class='names'>";
                foreach($students_array as $student) {
                  //takes the name of the student from DB
                  $query = "SELECT * FROM Students WHERE id='$student'";
                  $query_result = mysqli_query($connection, $query);
                  $random_student = mysqli_fetch_row($query_result)[1];
                  
                  echo "<p>$i. $random_student</p>"; //prints student in current team
                  $i++;
                }
              echo "</div></div>";
            }
          }
        ?>
        <script>
          // This script shows teams one by one with a delay of 1 second
          const teams = document.querySelectorAll('.team');
          let index = 0;

          function showNextTeam() {
            if (index < teams.length) {
              teams[index].style.display = 'block';
              teams[index].style.animation = 'blur 2s ease';
              teams[index].style.animationDelay = '-1.5s';
              index++;
              setTimeout(showNextTeam, 500); // 0.5 second delay
            }
          }

          showNextTeam();
        </script>
      </div>
    </main>
  </div>
<footer>Pavel Kliukin 2023 &copy;</footer>
</body>
</html>