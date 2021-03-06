<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/user.php";
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);
$user->email = $_GET["email"];

$stmt = $user->get_by_email();
$num = $stmt->rowCount();
 
if($num>0){ 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $user_result= array("id" => $id,
            "name" => $name,
            "email" => $email,
            "password" => $password);
    }
    http_response_code(200);
    echo json_encode($user_result);
} else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No users found.")
    );
}
?>