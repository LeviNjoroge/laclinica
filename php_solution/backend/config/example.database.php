<?php
// creating a database connection here
$host = "YOUR_HOST_GOES_HERE";
$username = "YOUR_USERNAME_GOES_HERE";
$password = "YOUR_PASSWORD_GOES_HERE";
$database = "YOUR_DATABASE_GOES_HERE";

$conn = mysqli_connect($host, $username, $password, $database);

if(!$conn){
    echo "Failed to connect to database";
}
?>