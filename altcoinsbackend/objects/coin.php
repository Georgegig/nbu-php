<?php
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/shared/utilities.php";

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
		$this->utilities = new Utilities();
    }
	
	function get(){ 
		// select all query
		$query = "SELECT
					id, name, symbol, rank, price, amount, portfolioId
				FROM
					" . $this->table_name . "
				WHERE id = '" . $this->id ."'" ;
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}	
	
	function update(){		
		// select all query
		$query = "UPDATE " . $this->table_name . "
				SET
					name = '" . $this->name . "', 
					symbol = '" . $this->symbol . "', 
					rank = '" . $this->rank . "', 
					price = '" . $this->price . "', 
					amount = '" . $this->amount . "', 
					portfolioId = '" . $this->portfolioId . "'
				WHERE id = '" . $this->id . "'";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	
	function create(){		
		// select all query
		$query = "INSERT INTO " . $this->table_name . " (id, name, symbol, rank, price, amount, portfolioId)
				VALUES
					('" . $this->utilities->getGUID() . "',
					'" . $this->name . "', 
					'" . $this->symbol . "',
					'" . $this->rank . "',
					'" . $this->price . "',
					'" . $this->amount . "', 
					'" . $this->portfolioId . "')";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}
?>