<?php
require "connection.php";
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // thumbnails  folder name
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // All moview query 
    
     
    $sql = "SELECT * FROM playing_movies";

    if (isset( $_POST['category_id'])) {
      $category_id = $_POST['category_id'];
    } else {
      echo "category_id required ";
      exit();
    }
    
    if (isset($_POST['title'])) {
      $title = $_POST['title'];
      $movieexist_query = "$sql WHERE title='$title'";
      $titleexistance = $conn->query($movieexist_query);
      if ($titleexistance->num_rows > 0) {
        echo "this movie already exists";
        exit();
      }
        // else{
        //   $title = $_POST['title'];
        // }
      
    } else {
      echo "title is required ";
      exit();
    }
   
    
    if (isset($_POST['description'])) {
      $description = $_POST['description'];
    } else {
      echo "description is required ";
      exit();
    }
    if (isset($_POST['year'])) {
      $year = $_POST['year'];
    } else {
      echo "year is required ";
      exit();
    }
   
    if (isset($_FILES["thumbnail"]["name"])) {
      // Image
      $filename = $_FILES["thumbnail"]["name"];
      $tempname = $_FILES["thumbnail"]["tmp_name"];  
    } else {
      echo "thumbnail image is required ";
      exit();
    }
   
    
    //   $thumbnail = $_POST['thumbnail'];
    
    if (isset($_POST['movies_types'])) {
      $movies_types = $_POST['movies_types'];
    } else {
      echo "movies_types is required ";
      exit();
    }
    
    if (isset($_POST['duration'])) {
      $duration = $_POST['duration'];
    } else {
      echo "duration is required ";
      exit();
    }
    
    if (isset($_POST['videio_link'])) {
      $videio_link = $_POST['videio_link'];
    } else {
      echo "videio_link is required ";
      exit();
    }
    
    if (isset($_POST['language'])) {
      $language = $_POST['language'];
    } else {
      echo "language is required ";
      exit();
    }
    
    $folder = "thumbnails/".$filename;  

    $sql = "SELECT * FROM categories WHERE id= '$category_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
                // output data of each row
                if (move_uploaded_file($tempname, $folder)) {
  
                  $sql = "INSERT INTO playing_movies (title,category_id, description, year, thumbnail, movies_types, duration, videio_link, language)
                  VALUES ('$title','$category_id', '$description', '$year','$folder','$movies_types','$duration','$videio_link','$language')";
                  
                  if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                  } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                  }
          
              }else{
          
                  echo "Image does not uploaded";
          
              }
            
    }else {
                $result = array("status" => "0", "message" => "Category not found");
                echo json_encode($result);
    }
   
    
  
    
    $conn->close();
  }else{
    echo "Method is not post";
  }
 
?>
