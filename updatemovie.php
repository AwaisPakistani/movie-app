<?php
require "connection.php";
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  // thumbnails  folder name
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // All moview query 
    
    $id = $_GET['id'];
    $sql = "SELECT * FROM playing_movies";
    
    $sql_all = "SELECT * FROM playing_movies WHERE id='$id'";
    $result_all = $conn->query($sql_all);
    $row_all = $result_all->fetch_all(MYSQLI_ASSOC);
    
    
    $category_id = $_POST['category_id'];
    
    
    if (isset($_POST['title'])) {
            $title = $_POST['title'];
            $movieexist_query = "$sql WHERE title='$title'";
            $titleexistance = $conn->query($movieexist_query);
            if ($titleexistance->num_rows > 0) {
                echo "this movie already exists";
                exit();
            }
    }else{
        $title=$row_all[0]['title']; 
    }
    if (isset($_POST['description'])) {
        $description = $_POST['description'];
    } else {
        $description=$row_all[0]['description']; 
    }
    
     
    if (isset($_POST['year'])) {
        $year = $_POST['year'];
    } else {
        $year=$row_all[0]['year']; 
    }
      
      
      if (isset($_FILES['thumbnail'])) {
            $sql_movies = "SELECT * FROM playing_movies WHERE id='$id'";
            $result_movies = $conn->query($sql_movies);
            $row_movies = $result_movies->fetch_all(MYSQLI_ASSOC);
            $path=$row_movies[0]['thumbnail'];
            if($path!=null){
                if(file_exists($path)){
                    $sql = "UPDATE playing_movies SET thumbnail='' WHERE id='$id'";
          
                    if ($conn->query($sql) === TRUE) {
                      echo "image path removed successfully";
                    } else {
                      echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    unlink($path);
                }else{
                    echo "file does not exists<br>";
                }
            }
            $filename = $_FILES["thumbnail"]["name"];
            $tempname = $_FILES["thumbnail"]["tmp_name"];  
      } else {
            $sql_movies = "SELECT * FROM playing_movies WHERE id='$id'";
            $result_movies = $conn->query($sql);
            $row_movies = $result_movies->fetch_all(MYSQLI_ASSOC);
            $folder=$row_movies[0]['thumbnail'];
            $exp_filename = explode('/',$folder);
            $file=$exp_filename[1];
            $filename = $file;
           
           
      }
    
    //   $thumbnail = $_POST['thumbnail'];
    if (isset($_POST['movies_types'])) {
        $movies_types = $_POST['movies_types'];
    } else {
        $movies_types=$row_all[0]['movies_types']; 
    }
    if (isset($_POST['duration'])) {
        $duration = $_POST['duration'];
    } else {
        $duration=$row_all[0]['duration']; 
    }
    if (isset($_POST['videio_link'])) {
        $videio_link = $_POST['videio_link'];
    } else {
        $videio_link=$row_all[0]['videio_link']; 
    }
    
    if (isset($_POST['language'])) {
        $language = $_POST['language'];
    } else {
        $language=$row_all[0]['language']; 
    }

    
    $folder = "thumbnails/".$filename;  

    $sql = "SELECT * FROM categories WHERE id= '$category_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
            
                // output data of each row
        if (isset($_FILES['thumbnail'])) {
            if (move_uploaded_file($tempname, $folder)) {
  
                $sql = "UPDATE playing_movies SET title='$title',category_id='$category_id',description='$description',year='$year',thumbnail='$folder',movies_types='$movies_types',duration='$duration',videio_link='$videio_link',language='$language' WHERE id='$id'";
                
                if ($conn->query($sql) === TRUE) {
                  echo "Record updated successfully";
                } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
                }
        
              }else{
          
                  echo "Image does not uploaded";
          
              }
        } else {
            $sql = "UPDATE playing_movies SET title='$title',category_id='$category_id',description='$description',year='$year',thumbnail='$folder',movies_types='$movies_types',duration='$duration',videio_link='$videio_link',language='$language' WHERE id='$id'";
                
            if ($conn->query($sql) === TRUE) {
              echo "Record updated successfully";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
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
