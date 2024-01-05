<?php
require "../connection.php";
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // thumbnails  folder name
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $name = $_POST['name'];
          //$currentdatatime = date("Y/m/d");
          $currentdatatime = date("Y-m-d h:i:sa");
          $sql = "INSERT INTO categories (name, created_at, updated_at)
          VALUES ('$name','$currentdatatime','$currentdatatime')";
          
          if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $conn->close();
  }else{
    echo "Method is not post";
  }
 
?>
