
<?php

$server     = "localhost";
$dbName     = "group7";
$dbUser     = "root";
$dbPassword = "";

   # Create Connection ... 
   $connection = mysqli_connect($server,$dbUser,$dbPassword,$dbName);

    if(!$connection){

        die('Error : '.mysqli_connect_error());
    }
?>