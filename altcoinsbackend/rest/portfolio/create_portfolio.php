<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/portfolio.php";
 
// instantiate database and portfolio object
$database = new Database();
$db = $database->getConnection();

// initialize object
$portfolio = new Portfolio($db);

$data = json_decode(file_get_contents("php://input"));

$portfolio->userId = $data->userId;

$portfolio_created = $portfolio->create();

if($portfolio_created){
	$result= array("message" => "Portfolio was created.",
            "userId" => $portfolio->userId,
        "success" => true);
    http_response_code(200);
    echo json_encode($result);
}
else{
    http_response_code(404);
    echo '{';
        echo '"message": "Unable to create portfolio."';
    echo '}';
}
?>