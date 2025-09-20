<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); // Use E_ALL during development
// Allow CORS (for JavaScript fetch requests)
header("Access-Control-Allow-Origin: *");
/*if using google phonts, cdns,  or external apis  u need to white list them here e.g
* script-src 'self' https://cdnjs.cloudflare.com; 
*style-src 'self' https://fonts.googleapis.com;
*font-src 'self' https://fonts.gstatic.com;
*/
//put all in one line
header("Content-Security-Policy: default-src 'self'; script-src 'self'; img-src 'self' data:; connect-src 'self'; form-action 'self'; base-uri 'self'; frame-ancestors 'self';");

date_default_timezone_set("Africa/Nairobi");

header('Content-Type:application/json');
include("db_connect.php");
include("functions.php");
$data = json_decode(file_get_contents("php://input"), true);
// CSRF check
// if (!$data || !isset($data['csrtfToken']) || $data['csrtfToken'] !== $_SESSION['csrf_token']) {
//     echo json_encode(["success" => false, "message" => !$data ? "Invalid JSON" : "CSRF validation failed" . $_SESSION['csrf_token']]);
//     exit;

$user = $_SESSION['user_id'];
$stmt = $con->prepare("SELECT * FROM `payment history` WHERE `user_unid` = ?");
$stmt->bind_param("s",$user);
$datArray = array();
if($stmt->execute()){
    $results = $stmt->get_result();
    while($data=$results->fetch_assoc()){
        $datArray[]=$data;
    }
    echo json_encode(["success" => true, "message" => $datArray]);
}else{
    echo json_encode(["success" => false, "message" => $datArray]);
}
?>