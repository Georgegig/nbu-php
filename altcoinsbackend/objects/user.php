<?php
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/shared/utilities.php";

class User{
    // database connection and table name
	private $utilities;
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $id;
    public $name;
    public $email;
    public $password;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;		
		$this->utilities = new Utilities();
    }
	
	function get(){ 
		// select all query
		$query = "SELECT
					id, email, name, password
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
					email = '" . $this->email . "', 
					name = '" . $this->name . "', 
					password = '" . $this->password . "'
				WHERE id = '" . $this->id . "'";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	
	function create(){		
		// select all query
		$query = "INSERT INTO " . $this->table_name . " (id, email, name, password)
				VALUES
					('" . $this->utilities->getGUID() . "',
					'" . $this->email . "', 
					'" . $this->name . "', 
					'" . $this->password . "')";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}
?>