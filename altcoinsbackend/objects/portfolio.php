<?php
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/shared/utilities.php";

class Portfolio{
    // database connection and table name
    private $conn;
    private $table_name = "portfolio";
	private $utilities;
 
    // object properties
    public $id;
    public $userId;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
		$this->utilities = new Utilities();
    }
	
	function get(){ 
		// select all query
		$query = "SELECT
					id, userId
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
					userId = '" . $this->userId . "'
				WHERE id = '" . $this->id . "'";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	
	function create(){		
		// select all query
		$query = "INSERT INTO " . $this->table_name . " (id, userId)
				VALUES
					('" . $this->utilities->getGUID() . "',
					'" . $this->userId . "')";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}
?>