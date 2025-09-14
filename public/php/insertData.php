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
$stmt = $con->prepare("SELECT unid, email, password_hash, accountStatus FROM users WHERE `email` = ? LIMIT 1");
$stmt->bind_param("s",$email);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if(!$user){
        echo json_encode(["success" => false, "message" => "Email not found"]);
        exit;
    }else{
        if($user['accountStatus']!=="active"){
         echo json_encode(["success" => false, "message" => "The account has been deactivated"]);
        }else{
            if($user && password_verify($password,$user['password_hash'])){
            //login success
            session_regenerate_id(true); // prevent session fixation
            $_SESSION['user_id'] = $user['unid'];
            echo json_encode(["success" => true, "message" => "Login successful"]);
            }else{
                echo json_encode(["success" => false, "message" => "Invalid email or password"]);
            }
        }
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
//admin login 
if(isset($data['adminloginStatus'])&& $data['adminloginStatus']==true){
$email = sanitize($data['adminEmail']);
$password = sanitize($data['adminPassword']);
$stmt = $con->prepare("SELECT unid, email, password_hash, accountStatus FROM administators WHERE `email` = ? LIMIT 1");
$stmt->bind_param("s",$email);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if(!$user){
        echo json_encode(["success" => false, "message" => "Email not found"]);
        exit;
    }else{
        if($user['accountStatus']!=="active"){
         echo json_encode(["success" => false, "message" => "The account has been deactivated"]);
        }else{
            //if($user && password_verify($password,$user['password_hash'])){
            if($password===$user['password_hash']){
            //login success
            session_regenerate_id(true); // prevent session fixation
            $_SESSION['admin_user_id'] = $user['unid'];
            echo json_encode(["success" => true, "message" => "Login successful"]);
            }else{
                echo json_encode(["success" => false, "message" => "Invalid email or password"]);
            }
        }
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
if(isset($data['profileUpdate'])&& $data['profileUpdate']==true){
    $unid =  $_SESSION['user_id'];
$Fname = sanitize($data['first_name']);
$Lname = sanitize($data['last_name']);
$email = sanitize($data['email']);
$tel = sanitize($data['tel']);
    $insertData = $con->prepare("UPDATE `users` SET 
    `first_name`= ?,`last_name`= ?,`email`= ?,`tel`= ?
     WHERE `unid`= ?");
    $insertData->bind_param("sssss",$Fname,$Lname,$email,$tel,$unid);
    if($insertData->execute()){
        echo json_encode(["success" => true, "message" => "Profile updated"]); 
    }else{
        echo json_encode(["success" => false, "message" => "error accured when updating profile"]); 
    }
}
if(isset($data['passwordResetStatus'])&& $data['passwordResetStatus']==true){
    $unid =  $_SESSION['user_id'];
    $oldpassword= sanitize($data['oldpassword']);
    $confirmnewpassword = sanitize($data['confirmnewpassword']);
   
    $stmt = $con->prepare("SELECT * FROM users WHERE `unid` = ? LIMIT 1");
    $stmt->bind_param("s",$unid);
    if($stmt->execute()){
        $results = $stmt->get_result();
        $user=$results->fetch_assoc();
        if($user && password_verify($oldpassword,$user['password_hash'])){
            $hashedPassword = password_hash($confirmnewpassword,PASSWORD_DEFAULT);
            $updatetData = $con->prepare("UPDATE `users` SET `password_hash`= ?
            WHERE `unid`= ?");
            $updatetData->bind_param("ss",$hashedPassword,$unid);
            if($updatetData->execute()){
                echo json_encode(["success" => true, "message" => "Password updated"]); 
                //send email to user to tell them that the password was changed if it wosnt then to block the action
            }else{
                echo json_encode(["success" => false, "message" => "error accured when updating password"]); 
            }
        }else{
            echo json_encode(["success" => false, "message" => "wrong old password"]);
        }
    }else{
        echo json_encode(["success" => false, "message" => "Database error"]);
    }
}
if(isset($data['preferenceStatus'])&& $data['preferenceStatus']==true){
    $unid =  $_SESSION['user_id'];
    $selectedValue = sanitize($data['selectedValue']);
        $insertData = $con->prepare("UPDATE `users` SET `notification_preference`= ?
        WHERE `unid`= ?");
        $insertData->bind_param("ss",$selectedValue,$unid);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "Preference updated"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when updating preference"]); 
        }
    }
if(isset($data['deactivateAccountStatus'])&& $data['deactivateAccountStatus']==true){
    $unid =  $_SESSION['user_id'];
    $accountStatus = 'deactivated';
        $insertData = $con->prepare("UPDATE `users` SET `accountStatus`= ?
        WHERE `unid`= ?");
        $insertData->bind_param("ss",$accountStatus,$unid);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "Account deactivated"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when deactivating Account"]); 
        }
    }
?>