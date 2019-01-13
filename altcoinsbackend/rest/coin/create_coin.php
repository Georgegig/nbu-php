<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/coin.php";
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();

// initialize object
$coin = new Coin($db);

$data = json_decode(file_get_contents("php://input"));

$coin->name = $data->name;
$coin->symbol = $data->symbol;
$coin->rank = $data->rank;
$coin->price = $data->price;
$coin->amount = $data->amount;
$coin->portfolioId = $data->portfolioId;

$coin_created = $coin->create();

if($coin_created){
	$result= array("message" => "Coin was created.",
            "name" => $coin->name,
            "symbol" => $coin->name,
            "rank" => $coin->name,
            "price" => $coin->name,
            "amount" => $coin->name,
            "portfolioId" => $coin->email);
    http_response_code(200);
    echo json_encode($result);
}
else{
    echo '{';
        echo '"message": "Unable to create coin."';
    echo '}';
}
?>