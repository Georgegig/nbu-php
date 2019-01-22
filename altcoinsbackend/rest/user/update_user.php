<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/user.php";
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->id = $data->id;
$user->name = $data->name;
$user->email = $data->email;
$user->password = $data->password;

$user_updated = $user->update();

if($user_updated){
	$result= array("message" => "User was updated.",
			"id" => $user->id,
            "name" => $user->name,
            "email" => $user->email);
    http_response_code(200);
    echo json_encode($result);
}
else{
    http_response_code(404);
    echo '{';
        echo '"message": "Unable to update user."';
    echo '}';
}
?>