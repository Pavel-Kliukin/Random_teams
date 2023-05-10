<?php
$host = "myprojectdb";
$user = "Pavel";
$pass = "777";
$db_name = "phpProjectDB";
$connection = new mysqli($host, $user, $pass, $db_name);
if ($connection->connect_error) {
    die("connection failed" . $connection->connect_error);
}
?>

<h1>Hello</h1>

<?php
$select_query = "SELECT * FROM fortest";
$select_result = mysqli_query($connection, $select_query);

while ($row = mysqli_fetch_assoc($select_result)) {
  foreach ($row as $value) {
    echo ($value) . " ";
  }
  echo "<br>";
}