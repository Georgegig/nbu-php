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

// register user
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
$user_registration = curl_exec($ch);
curl_close($ch);
$user_registration = json_decode($user_registration);

if ($user_registration == false) {	
    http_response_code(404);
    echo json_encode(
        array("message" => "Error occured.")
    );
} else {
    if ($user_registration->success == true) {
        // create portfolio
        $some_string = json_encode(array("userId" => $user_registration->id));     
        $chh = curl_init('http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/portfolio');                                                                      
        curl_setopt($chh, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($chh, CURLOPT_POSTFIELDS, $some_string);                                                                  
        curl_setopt($chh, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($chh, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($some_string))                                                                       
        );                                                                                                                   
        $portfolio_creation = curl_exec($chh);
        curl_close($chh);                                                                              
        $portfolio_creation = json_decode($portfolio_creation);
        if ($portfolio_creation->success) {
            $result= array("success" => true);
            http_response_code(200);
            echo json_encode($result);
        }
    } else {
        $result= array("success" => false);
        http_response_code(200);
        echo json_encode($result);
    }
}
?>