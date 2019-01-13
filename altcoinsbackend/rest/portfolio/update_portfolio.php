<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/portfolio.php";
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$portfolio = new Portfolio($db);

$data = json_decode(file_get_contents("php://input"));

$portfolio->id = $data->id;
$portfolio->userId = $data->userId;

$portfolio_updated = $portfolio->update();

if($portfolio_updated){
	$result= array("message" => "Portfolio was updated.",
			"id" => $portfolio->id,
            "userId" => $portfolio->userId);
    http_response_code(200);
    echo json_encode($result);
}
else{
    echo '{';
        echo '"message": "Unable to update portfolio."';
    echo '}';
}
?>