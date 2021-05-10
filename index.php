<?php

// Require database and models
    require('config/Database.php');
    require('models/Author.php');
    require('models/Category.php');
    require('models/Quote.php');

// Connect to database
    $database = new Database();
    $db = $database->connect();

// Instantiate each model
    $author = new Author($db);
    $category = new Category($db);
    $quote = new Quote($db);

// Get parameters sent to controller
    $authorId = filter_input(INPUT_GET, 'authorId', FILTER_VALIDATE_INT);
    $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_VALIDATE_INT);
    $limit = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);

    // Get request quote data
    if ($authorId) {
        $quote->authorId = $authorId;
    }
    if ($categoryId) {
        $quote->categoryId = $categoryId;
    }
    if ($limit) {
        $quote->limit = $limit;
    }

// Read Data
    $authors = $author->read();
    $categories = $category->read();
    $quotes = $quote->read();

// Include the view
    include('view/quote_list.php');

  