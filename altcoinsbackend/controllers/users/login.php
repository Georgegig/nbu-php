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
$user = new User($db);
// request user from rest api
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/user?email='.$_POST['email']
));
$data = curl_exec($curl);
curl_close($curl);

if ($data == false) {	
    http_response_code(404);
    echo json_encode(
        array("message" => "No users found.")
    );
} else {
    $json_object = json_decode($data, true);
    foreach ($json_object as $key => $value) 
    {
        $user->{$key} = $value;
    }
	if ($user->password == $_POST['password']) {
        $result= array("success" => true);
        http_response_code(200);
        echo json_encode($result);
    } else {
        $result= array("success" => false);
        http_response_code(200);
        echo json_encode($result);
    }
}
?>