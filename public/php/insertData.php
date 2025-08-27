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
include("db_connect.php");
include("functions.php");
$data = json_decode(file_get_contents("php://input"), true);
// CSRF check
if (!$data || !isset($data['csrtfToken']) || $data['csrtfToken'] !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => !$data ? "Invalid JSON" : "CSRF validation failed"]);
    exit;
}
if(isset($data['loginStatus'])&& $data['loginStatus']==true){
$email = sanitize($data['loginEmail']);
$password = sanitize($data['loginPassword']);
$stmt = $con->prepare("SELECT * FROM users WHERE `email` = ? LIMIT 1");
$stmt->bind_param("s",$email);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if($user && password_verify($password,$user['password_hash'])){
        //login success
         $_SESSION['user_id'] = $user['unid'];
         echo json_encode(["success" => true, "message" => "Login successful"]);
    }else{
        echo json_encode(["success" => false, "message" => "Invalid email or password"]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}

if(isset($data['signupStatus'])&& $data['signupStatus']==true){
$Fname = sanitize($data['Fname']);
$Lname = sanitize($data['Lname']);
$signupemail = sanitize($data['signupemail']);
$tel = sanitize($data['tel']);
$confirmPassword = (sanitize($data['confirmPassword']));
$hashedPassword = password_hash($confirmPassword,PASSWORD_DEFAULT);
$stmt = $con->prepare("SELECT * FROM users WHERE `email` = ? LIMIT 1");
$stmt->bind_param("s",$signupemail);
$unid = random_num(5);
if($stmt->execute()){
    $results = $stmt->get_result();
    if($results->num_rows==0){
        //no match found
        //insert the data
        $insertData = $con->prepare("INSERT INTO users (`unid`, `first_name`, `last_name`, `email`, `tel`, `password_hash`)VALUES(?,?,?,?,?,?)");
        $insertData->bind_param("ssssss",$unid,$Fname,$Lname,$signupemail,$tel,$hashedPassword);
        if($insertData->execute()){
            $_SESSION['user_id'] = $unid;
            echo json_encode(["success" => true, "message" => "signing up successfull"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when signingup"]); 
        }
    }else{
       echo json_encode(["success" => false, "message" => "Email already signing up"]); 
    }
   
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
?>