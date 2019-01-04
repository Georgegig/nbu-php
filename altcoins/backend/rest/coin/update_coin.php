<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

// include database and object files
include_once '../../config/database.php';
include_once '../../objects/coin.php';
 
// instantiate database and coin object
$database = new Database();
$db = $database->getConnection();

// initialize object
$coin = new Coin($db);

$data = json_decode(file_get_contents("php://input"));

$coin->id = $data->id;
$coin->name = $data->name;
$coin->symbol = $data->symbol;
$coin->rank = $data->rank;
$coin->price = $data->price;
$coin->amount = $data->amount;
$coin->portfolioId = $data->portfolioId;

$coin_updated = $coin->update();

if($coin_updated){
	$result= array("message" => "Coin was updated.",
			"id" => $coin->id,
            "name" => $coin->name,
            "symbol" => $coin->symbol,
            "rank" => $coin->rank,
            "price" => $coin->price,
            "amount" => $coin->amount,
            "portfolioId" => $coin->portfolioId);
    http_response_code(200);
    echo json_encode($result);
}
else{
    echo '{';
        echo '"message": "Unable to update coin."';
    echo '}';
}
?>