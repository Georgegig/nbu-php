<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/user.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/shared/utilities.php";
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

$user->id = (new Utilities())->getGUID();
$user->name = $data->name;
$user->email = $data->email;
$user->password = $data->password;

$user_created = $user->create();

if($user_created){
    $result= array("message" => "User was created.",
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
        "success" => true);
    http_response_code(200);
    echo json_encode($result);
}
else{
    echo '{';
        echo '"message": "Unable to create user."';
    echo '}';
}
?>