<?php
class Coin{
    // database connection and table name
    private $conn;
    private $table_name = "coin";
 
    // object properties
    public $id;
    public $name;
    public $symbol;
    public $rank;
    public $price;
    public $amount;
    public $portfolioId;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}
?>