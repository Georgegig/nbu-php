<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/coin.php";
 
// instantiate database and coin object
$database = new Database();
$db = $database->getConnection();
$coins = array();
 
// initialize object
$coin = new Coin($db);
$coin->portfolioId = $_GET["portfolioid"];

$stmt = $coin->getByPortfolioId();
$num = $stmt->rowCount();
 
if($num>0){ 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $coin_result= array("id" => $id,
            "name" => $name,
			"symbol" => $symbol,
			"rank" => $rank,
			"price" => $price,
			"amount" => $amount,
            "portfolioId" => $portfolioId);

        array_push($coins, $coin_result);
    }
} 
http_response_code(200);
echo json_encode($coins);
?>