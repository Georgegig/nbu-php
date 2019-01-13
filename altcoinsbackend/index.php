<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
$resource_uri = explode('/altcoinsbackend', $request_uri, 2)[1];

switch ($resource_uri) {
    case '/user':
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				require './rest/user/get_user.php';
				break;
			case 'PUT':
				require './rest/user/update_user.php';
				break;
			case 'POST':
				require './rest/user/create_user.php';
				break;
			default:
				require './shared/404.php';
			
		}
        break;	
    case '/coin':
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				require './rest/coin/get_coin.php';
				break;
			case 'PUT':
				require './rest/coin/update_coin.php';
				break;
			case 'POST':
				require './rest/coin/create_coin.php';
				break;
			default:
				require './shared/404.php';
			
		}
        break;
    case '/portfolio':
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				require './rest/portfolio/get_portfolio.php';
				break;
			case 'PUT':
				require './rest/portfolio/update_portfolio.php';
				break;
			case 'POST':
				require './rest/portfolio/create_portfolio.php';
				break;
			default:
				require './shared/404.php';
			
		}
        break;
    default:
		require './shared/404.php';
}
?>