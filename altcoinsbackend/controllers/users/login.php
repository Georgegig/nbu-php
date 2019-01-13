<?php	
// get user by email
// validate password
// return result
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/user.php";
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// request user from rest api
$data = file_get_contents('http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/user?email=g@g.bg');

if ($data == false) {	
    http_response_code(404);
    echo json_encode(
        array("message" => "No users found.")
    );
} else {
	$json_object = json_decode($data, true);
	foreach ($json_object as $key => $value) $user->{$key} = $value;
	var_dump($user);	
}
?>