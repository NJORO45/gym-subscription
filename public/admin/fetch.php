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
if(isset($data['tariffData']) && $data['tariffData']){
    $stmt = $con->prepare("SELECT * FROM plans");
    $arrayData=array();
    if($stmt->execute()){
        $results = $stmt->get_result();
       while($data = $results->fetch_assoc()){
        $arrayData[]=$data;
        
       }
       echo json_encode(["success"=>true,"tariffs"=>$arrayData]);
    }else{
        echo json_encode(["success"=>false,"active_members"=>"erroe"]);
    }
}

if(isset($data['addplanStatus'])&& $data['addplanStatus']==true){
$DurationOption = sanitize($data['DurationOption']);
$planeName = sanitize($data['planeName']);
$amount = sanitize($data['amount']);
$durationValue = sanitize($data['durationValue']);
$discountValue = sanitize($data['discountValue']);
$unid = random_num(5);
$stmt = $con->prepare("SELECT * FROM plans WHERE `name` = ? LIMIT 1");
$stmt->bind_param("s",$planeName);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if(!$user){
        
        $insertData = $con->prepare("INSERT INTO plans (`unid`, `name`, `duration_value`, `duration_type`, `tariff`,`discount`)VALUES(?,?,?,?,?,?)");
        $insertData->bind_param("ssssss",$unid,$planeName,$durationValue,$DurationOption,$amount,$discountValue);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "plan added succesfully"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when adding plan"]); 
        }
    }else{
        echo json_encode(["success" => false, "message" => "Similar plan found"]);
        exit;
        
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
if(isset($data['editPlanStatus'])&& $data['editPlanStatus']==true){
$DurationOption = sanitize($data['editDurationOption']);
$planeName = sanitize($data['editplaneName']);
$amount = sanitize($data['editamount']);
$durationValue = sanitize($data['editdurationValue']);
$discountValue = sanitize($data['editdiscountValue']);
$unid = sanitize($data['unid']);
$stmt = $con->prepare("SELECT * FROM plans WHERE `unid` = ? LIMIT 1");
$stmt->bind_param("s",$unid);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if(!$user){
        
        
        echo json_encode(["success" => false, "message" => "Plan was not found"]);
        exit;
    }else{
        $insertData = $con->prepare("UPDATE `plans` SET `name`=?,`duration_value`=?,`duration_type`=?,`tariff`=?,`discount`=? WHERE unid =?");
        $insertData->bind_param("ssssss",$planeName,$durationValue,$DurationOption,$amount,$discountValue,$unid);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "plan updated succesfully"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when updating plan"]); 
        }
        
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
?>