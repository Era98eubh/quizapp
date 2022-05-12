<?php 
session_start();
?>
<?php


$servername = "localhost";
$username = "root";
$password = "";
$port = 3306;
$dbname ="test";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['SERVER_NAME'] == 'localhost') 
{
    $base_url = "http://localhost/trail/";
}
else
{
    $base_url = "http://exam.lk/trail/";
}

//echo "Connected successfully";



?>

