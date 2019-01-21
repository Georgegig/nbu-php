<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/portfolio.php";
 
// instantiate database and portfolio object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$portfolio = new Portfolio($db);
echo $_GET["userid"];
$portfolio->userId = $_GET["userid"];

$stmt = $portfolio->getByUserId();
$num = $stmt->rowCount();
 
if($num>0){ 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $portfolio_result= array("id" => $id,
            "userId" => $userId);
    }
    http_response_code(200);
    echo json_encode($portfolio_result);
} else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No portfolios found.")
    );
}
?>