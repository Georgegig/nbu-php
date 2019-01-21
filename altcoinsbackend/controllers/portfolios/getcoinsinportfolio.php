<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/config/database.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/user.php";
include_once "$_SERVER[DOCUMENT_ROOT]/altcoinsbackend/objects/portfolio.php";
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$pf = new Portfolio($db);
// request user from rest api
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/user?email='.$_GET["email"]
));
$user_data = curl_exec($curl);
curl_close($curl);

if ($user_data == false) {	
    http_response_code(404);
    echo json_encode(
        array("message" => "No coins found.")
    );
} else {
    $json_object = json_decode($user_data, true);
    foreach ($json_object as $key => $value) 
    {
        $user->{$key} = $value;
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/portfolio?userid='.$user->id
    ));
    $portfolio_data = curl_exec($curl);
    curl_close($curl);

    $portfolio = json_decode($portfolio_data);
    foreach ($json_object as $key => $value) 
    {
        $pf->{$key} = $value;
    }

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/coin?portfolioid='.$pf->id
    ));
    $coins = curl_exec($curl);
    curl_close($curl);

    echo $coins;

	// if ($user->password == $params->password) {
    //     $result= array("success" => true,
    //     "username" => $user->name);
    //     http_response_code(200);
    //     echo json_encode($result);
    // } else {
    //     $result= array("success" => false);
    //     http_response_code(200);
    //     echo json_encode($result);
    // }
}
?>