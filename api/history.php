<?php 
require_once './config.inc.php';
require_once '../includes/index.inc.php';

// Tell the browser to expect JSON rather than HTML 
header('Content-Type: application/json; charset=utf-8');
// indicate whether other domains can use this API 
header("Access-Control-Allow-Origin: *"); 

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS)); 
    $historyGateway = new HistoryDB($conn); 
    if (isCorrectQueryStringInfo('ref'))
        $histories = $historyGateway->getAllForHistory($_GET['ref']);
    else
        $histories = $historyGateway->getAll(); 

    echo json_encode( $histories, JSON_NUMERIC_CHECK ); 
} catch (Exception $e) { die( $e->getMessage() ); } 

function isCorrectQueryStringInfo($param) {
    if ( isset($_GET[$param]) && !empty($_GET[$param]) ) {
        return true;
    } else {
        return false;
    }
}
?>