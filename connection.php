<?php
$hostName = "localhost";
$userName = "root";
$userPass = "";
$dbName = "movies";
 $conn = mysqli_connect($hostName,$userName,$userPass,$dbName);
 if (!$conn) {
    echo "connection Faild";
 }
 else echo "connected sucessfully";
?>  