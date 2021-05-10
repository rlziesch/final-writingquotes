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

  // Get ID
  $quote->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get quote
  $quote->read_single();

  // Create array
  $quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category
  );

  // Make JSON
  print_r(json_encode($quote_arr));