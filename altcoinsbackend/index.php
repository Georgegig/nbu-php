<?php
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
$resource_uri = explode('/altcoinsbackend', $request_uri, 2)[1];

switch ($resource_uri) {
	case '/login':
		switch($_SERVER['REQUEST_METHOD']) {
			case 'POST':
				require './controllers/users/login.php';
				break;
			default:
				require './shared/404.php';
				break;
		}
		break;
	case '/getportfolio':
		switch($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				require './controllers/portfolios/getcoinsinportfolio.php';
				break;
			default:
				require './shared/404.php';
				break;
		}
		break;
	case '/addcoin':
		switch($_SERVER['REQUEST_METHOD']) {
			case 'POST':
				require './controllers/portfolios/addcoininportfolio.php';
				break;
			default:
				require './shared/404.php';
				break;
		}
		break;
	case '/register':
		switch($_SERVER['REQUEST_METHOD']) {
			case 'POST':
				require './controllers/users/register.php';
				break;
			default:
				require './shared/404.php';
				break;
		}
		break;
	case '/user':
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				if (isset($_GET["id"])) {
					require './rest/user/get_user.php';					
				} elseif (isset($_GET["email"])) {
					require './rest/user/get_user_by_email.php';
				} else {
					require './shared/404.php';
				}
				break;
			case 'PUT':
				require './rest/user/update_user.php';
				break;
			case 'POST':
				require './rest/user/create_user.php';
				break;
			default:
				require './shared/404.php';	
				break;
		}
        break;	
    case '/coin':
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				if (isset($_GET["id"])) {
					require './rest/coin/get_coin.php';				
				} elseif (isset($_GET["portfolioid"])) {
					require './rest/coin/get_coins_by_portfolioid.php';
				} else {
					require './shared/404.php';
				}
				break;
			case 'PUT':
				require './rest/coin/update_coin.php';
				break;
			case 'POST':
				require './rest/coin/create_coin.php';
				break;
			default:
				require './shared/404.php';
				break;
			
		}
        break;
    case '/portfolio':
		switch ($_SERVER['REQUEST_METHOD']) {
			case 'GET':
				if (isset($_GET["id"])) {
					require './rest/portfolio/get_portfolio.php';					
				} elseif (isset($_GET["userid"])) {
					require './rest/portfolio/get_portfolio_by_userid.php';
				} else {
					require './shared/404.php';
				}
				break;
			case 'PUT':
				require './rest/portfolio/update_portfolio.php';
				break;
			case 'POST':
				require './rest/portfolio/create_portfolio.php';
				break;
			default:
				require './shared/404.php';
				break;
			
		}
        break;
    default:
		require './shared/404.php';
		break;
}
?>