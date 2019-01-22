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

$params = json_decode(file_get_contents("php://input"));
// request user from rest api
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/user?email='.$params->email
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

    $cr = curl_init();
    curl_setopt_array($cr, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/portfolio?userid='.$user->id
    ));
    $portfolio_data = curl_exec($cr);
    curl_close($cr);

    if ($portfolio_data == false) {	
        http_response_code(404);
        echo json_encode(
            array("message" => "No coins found.")
        );
    } else {
        $j_obj = json_decode($portfolio_data, true);        
        foreach ($j_obj as $key => $value) 
        {
            $pf->{$key} = $value;
        }
        $coin = new \stdClass();
        $coin->name = $params->name;
        $coin->symbol = $params->symbol;
        $coin->rank = $params->rank;
        $coin->price = $params->price;
        $coin->amount = $params->amount; 
        $coin->portfolioId = $pf->id;
        
        $data_string = json_encode($coin);
        $ch = curl_init('http://'.$_SERVER['HTTP_HOST'].'/altcoinsbackend/coin');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
        $coin_creation = curl_exec($ch);
        curl_close($ch);
        $coin_creation = json_decode($coin_creation);
        if ($coin_creation->success) {
            $result= array("success" => true);
            http_response_code(200);
            echo json_encode($result);
        } else {
            $result= array("success" => false);
            http_response_code(200);
            echo json_encode($result);
        }
    }    
}
?>