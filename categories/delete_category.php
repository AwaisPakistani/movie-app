<?php
require "../connection.php";
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // thumbnails  folder name
  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
          $id = $_GET['id'];
          
          $sql = "DELETE FROM categories WHERE id='$id'";
          
          if ($conn->query($sql) === TRUE) {
            echo "Record Deleted successfully";
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
          $conn->close();
  }else{
    echo "Method is not delete";
  }
 
?>
