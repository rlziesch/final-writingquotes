<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require('../../config/Database.php');
  require('../../models/Category.php');

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate category object
  $category = new Category($db);

  // Category read query
  $result = $category->read();
  
  // Get row count
  $num = $result->rowCount();

  // Check if any categories
  if($num > 0) {
        // Category array
        $category_arr = array();
       
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
          extract($row);

          $category_item = array(
            'id' => $id,
            'category' => $category
          );

          // Push to "data"
          array_push($category_arr, $category_item);
        }

        // Turn to JSON & output
        echo json_encode($category_arr);

  } else {
        // No Categories
        echo json_encode(
          array('message' => 'No Categories Found')
        );
  }
