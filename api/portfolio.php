<?php 
require_once './config.inc.php';
require_once '../includes/index.inc.php';

// Tell the browser to expect JSON rather than HTML 
header('Content-Type: application/json; charset=utf-8');
// indicate whether other domains can use this API 
header("Access-Control-Allow-Origin: *"); 

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS)); 
    $portfolioGateway = new PortfolioDB($conn); 
    if (isCorrectQueryStringInfo('ref'))
        $portfolios = $portfolioGateway->getAllForPortfolio($_GET['ref']);
    else
        $portfolios = $portfolioGateway->getAll(); 

    echo json_encode( $portfolios, JSON_NUMERIC_CHECK ); 
} catch (Exception $e) { die( $e->getMessage() ); } 

function isCorrectQueryStringInfo($param) {
    if ( isset($_GET[$param]) && !empty($_GET[$param]) ) {
        return true;
    } else {
        return false;
    }
}
?>