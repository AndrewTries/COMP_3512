<?php 
require_once '../includes/config.inc.php';
require_once '../includes/index.inc.php';

// Tell the browser to expect JSON rather than HTML 
header('Content-Type: application/json; charset=utf-8');
// indicate whether other domains can use this API 
header("Access-Control-Allow-Origin: *"); 

try {
    $conn = DatabaseHelper::createConnection(array(DBCONNSTRING, DBUSER, DBPASS)); 
    $companyGateway = new CompanyDB($conn); 
    if (isCorrectQueryStringInfo('ref'))
        $companies = $companyGateway->getAllForCompany($_GET['ref']);
    else {
        $companyGateway = new CompanyDB($conn); 
        $companies = $companyGateway->getAll(); 
    }

    echo json_encode( $companies, JSON_NUMERIC_CHECK ); 
} catch (Exception $e) { die( $e->getMessage() ); } 

function isCorrectQueryStringInfo($param) {
    if ( isset($_GET[$param]) && !empty($_GET[$param]) ) {
        return true;
    } else {
        return false;
    }
}
?>