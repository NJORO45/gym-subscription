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

header('Content-Type:application/json');
include("../php/db_connect.php");
include("../php/functions.php");
$data = json_decode(file_get_contents("php://input"), true);
// CSRF check
if (!$data || !isset($data['adminCsrfToken']) || $data['adminCsrfToken'] !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => !$data ? "Invalid JSON" : "CSRF validation failed"]);
    exit;
}
if(isset($data['activeMembersData']) && $data['activeMembersData']){
    $stmt = $con->prepare("SELECT * FROM users WHERE accountStatus = ?");
    $accountStatus= "active";
    $stmt->bind_param("s",$accountStatus);
    if($stmt->execute()){
        $results = $stmt->get_result();
        $data = $results->num_rows;
        echo json_encode(["success"=>true,"active_members"=>$data]);
    }else{
        echo json_encode(["success"=>false,"active_members"=>"erroe"]);
    }
}
if(isset($data['trainerData']) && $data['trainerData']){
    $stmt = $con->prepare("SELECT * FROM trainers WHERE status = ?");
    $accountStatus= "active";
    $stmt->bind_param("s",$accountStatus);
    if($stmt->execute()){
        $results = $stmt->get_result();
        $data = $results->num_rows;
        echo json_encode(["success"=>true,"active_members"=>$data]);
    }else{
        echo json_encode(["success"=>false,"active_members"=>"erroe"]);
    }
}
if(isset($data['recentMembersData']) && $data['recentMembersData']){
    $stmt = $con->prepare("SELECT first_name, last_name, email, tel, created_at FROM users WHERE accountStatus = ? LIMIT 10");
    $accountStatus= "active";
    $stmt->bind_param("s",$accountStatus);
    $arrayData=array();
    if($stmt->execute()){
        $results = $stmt->get_result();
       while($data = $results->fetch_assoc()){
        $arrayData[]=$data;
        
       }
       echo json_encode(["success"=>true,"active_members"=>$arrayData]);
    }else{
        echo json_encode(["success"=>false,"active_members"=>"erroe"]);
    }
}
?>