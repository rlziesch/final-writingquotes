<?php
  class Quote {
    // DB Stuff
    private $conn;
    private $table = 'quotes';

    // Properties
    public $id;
    public $quote;
    public $authorId;
    public $categoryId;
   // public $category;
   // public $author;
    public $limit;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get quotes
    public function read() {
      // Create query
      $query = 'SELECT
        Q.id,
        Q.quote,
        Q.categoryId,
        Q.authorId,
        A.author,
        C.category
      FROM  
        ' . $this->table . ' Q
        LEFT JOIN authors A ON Q.authorId = A.id
        LEFT JOIN categories C ON Q.categoryId = C.id ';
        
        if ($this->authorId && $this->categoryId) {
          $query = $query . ' WHERE Q.authorId = :authorId 
          AND Q.categoryId = :categoryId ';
      
        } else if ($this->authorId) {
          $query = $query .' WHERE Q.authorId = :authorId ';
              
        } else if ($this->categoryId) {
          $query = $query . ' WHERE Q.categoryId = :categoryId ';

        } else {
          //return all
        }

        if ($this->limit) {
          $query = $query . ' LIMIT :limit ';
        }
        
        $stmt = $this->conn->prepare($query);

        //bind values if needed
       if ($this->authorId) {
          $stmt->bindParam(':authorId', $this->authorId);
       }
       if ($this->categoryId) {
          $stmt->bindParam(':categoryId', $this->categoryId);
        }
      if ($this->limit) {
         $stmt->bindValue(':limit', $this->limit, PDO::PARAM_INT);
      }

        $stmt->execute();
        return $stmt;

    }

    // Get single quote
  public function read_single(){

    // Create query
    $query = 'SELECT
        Q.id,
        Q.quote,
        Q.categoryId,
        Q.authorId,
        A.author,
        C.category
      FROM
        ' . $this->table . ' Q
        LEFT JOIN authors A ON Q.authorId = A.id
        LEFT JOIN categories C ON Q.categoryId = C.id
      WHERE
        Q.id = ?
      LIMIT 0,1';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      $this->id = $row['id'];
      $this->quote = $row['quote'];
      $this->author = $row['author'];
      $this->category = $row['category'];
  }

  // Create Quote
  public function create() {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
        quote = :quote,
        authorId = :authorId,
        categoryId = :categoryId';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->quote = htmlspecialchars(strip_tags($this->quote));
  $this->authorId = htmlspecialchars(strip_tags($this->authorId));
  $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

  // Bind data
  $stmt->bindParam(':quote', $this->quote);
  $stmt->bindParam(':authorId', $this->authorId);
  $stmt->bindParam(':categoryId', $this->categoryId);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
  }

  // Update Category
  public function update() {
    // Create Query
    $query = 'UPDATE ' .
      $this->table . '
    SET
        id = :id,
        quote = :quote,
        authorId = :authorId,
        categoryId = :categoryId
        WHERE
        id = :id';

  // Prepare Statement
  $stmt = $this->conn->prepare($query);

  // Clean data
  $this->id = htmlspecialchars(strip_tags($this->id));
  $this->quote = htmlspecialchars(strip_tags($this->quote));
  $this->authorId = htmlspecialchars(strip_tags($this->authorId));
  $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));


  // Bind data
  $stmt-> bindParam(':id', $this->id);
  $stmt-> bindParam(':quote', $this->quote);
  $stmt-> bindParam(':authorId', $this->authorId);
  $stmt-> bindParam(':categoryId', $this->categoryId);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  // Delete Category
  public function delete() {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind Data
    $stmt-> bindParam(':id', $this->id);

    // Execute query
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
