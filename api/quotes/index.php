<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  require('../../config/Database.php');
  require('../../models/Quote.php');

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate object
  $quote = new Quote($db);

  //get parameters
  $authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
  $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
  $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
 
  // assign values
 if ($authorId) {
  $quote->authorId = $authorId;
}
if ($categoryId) {
  $quote->categoryId = $categoryId;
}
if ($limit) {
  $quote->limit = $limit;
}

  // Quote query
  $result = $quote->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any quotes
  if($num > 0) {
    // Quote array
    $quotes_arr = array();
 
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $quotes_item = array(
        'id' => $id,
        'quote' => html_entity_decode($quote),
        'author' => $author,
        'categories' => $category,
        'authorId' => $authorId,
        'categoryId' => $categoryId
      );

      // Push to "data"
      array_push($quotes_arr, $quotes_item);
    
    }

    // Turn to JSON & output
    echo json_encode($quotes_arr);

  } else {
    // No Quotes
    echo json_encode(
      array('message' => 'No Quotes Found')
    );
  }
