<?php
require "../connection.php";
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // thumbnails  folder name
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $id = $_GET['id'];
          $name = $_POST['name'];
          //$currentdatatime = date("Y/m/d");
          $currentdatatime = date("Y-m-d h:i:sa");
          
          $sql = "UPDATE categories SET name='$name',updated_at='$currentdatatime' WHERE id='$id'";
          
          if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $conn->close();
  }else{
    echo "Method is not post";
  }
 
?>
