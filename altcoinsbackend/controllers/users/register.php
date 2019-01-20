<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/user.php";
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
// request user from rest api
// Get cURL resource
$params = json_decode(file_get_contents("php://input"));                                                              
$data_string = json_encode($params);                                                                                                                     
$ch = curl_init('http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/user');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
                                                                                                                     
$data = curl_exec($ch);
curl_close($ch);

$data = json_decode($data);

if ($data == false) {	
    http_response_code(404);
    echo json_encode(
        array("message" => "Error occured.")
    );
} else {
	if ($data->success == true) {
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