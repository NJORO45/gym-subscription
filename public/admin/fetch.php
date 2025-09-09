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
//membersData:true,
if(isset($data['membersData']) && $data['membersData']){
    $stmt = $con->prepare("SELECT first_name, unid, last_name, email, tel,accountStatus, created_at FROM users");
    $arrayData=array();
    if($stmt->execute()){
        $results = $stmt->get_result();
       while($data = $results->fetch_assoc()){
        $arrayData[]=$data;
        
       }
       echo json_encode(["success"=>true,"members"=>$arrayData]);
    }else{
        echo json_encode(["success"=>false,"members"=>"erroe"]);
    }
}
if(isset($data['trainersData']) && $data['trainersData']){
    $stmt = $con->prepare("SELECT * FROM trainers");
    $arrayData=array();
    if($stmt->execute()){
        $results = $stmt->get_result();
       while($data = $results->fetch_assoc()){
        $arrayData[]=$data;
        
       }
       echo json_encode(["success"=>true,"trainers"=>$arrayData]);
    }else{
        echo json_encode(["success"=>false,"trainers"=>"erroe"]);
    }
}
if(isset($data['blacklistmembersData']) && $data['blacklistmembersData']){
    $stmt = $con->prepare("SELECT first_name, unid, last_name, email, tel,accountStatus, created_at FROM users WHERE accountStatus=?");
    $accountStatus="blacklisted";
    $stmt->bind_param("s",$accountStatus);
    $arrayData=array();
    if($stmt->execute()){
        $results = $stmt->get_result();
       while($data = $results->fetch_assoc()){
        $arrayData[]=$data;
        
       }
       echo json_encode(["success"=>true,"members"=>$arrayData]);
    }else{
        echo json_encode(["success"=>false,"members"=>"erroe"]);
    }
}
if(isset($data['registrationStatus'])&& $data['registrationStatus']==true){
$registerEmail = sanitize($data['registerEmail']);
$registerTel = sanitize($data['registerTel']);
$registerLname = sanitize($data['registerLname']);
$registerFname = sanitize($data['registerFname']);
$unid = random_num(5);
$stmt = $con->prepare("SELECT * FROM users WHERE `email` = ? LIMIT 1");
$stmt->bind_param("s",$registerEmail);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if($user){
        echo json_encode(["success" => false, "message" => "User data exists"]);
    }else{
       $insertData = $con->prepare("INSERT INTO users (`unid`, `first_name`, `last_name`, `email`, `tel`)VALUES(?,?,?,?,?)");
        $insertData->bind_param("sssss",$unid,$registerFname,$registerLname,$registerEmail,$registerTel);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "Member added succesfully"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when adding member"]); 
        }
        
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
if(isset($data['editmemberDataStatus'])&& $data['editmemberDataStatus']==true){
$editMemberId = sanitize($data['editMemberId']);
$editmemberEmail = sanitize($data['editmemberEmail']);
$editMemberTel = sanitize($data['editMemberTel']);
$editmemberFname = sanitize($data['editmemberFname']);
$editmemberLname = sanitize($data['editmemberLname']);
$unid = random_num(5);
$stmt = $con->prepare("SELECT * FROM users WHERE `unid` = ? LIMIT 1");
$stmt->bind_param("s",$editMemberId);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if($user){
        $insertData = $con->prepare("UPDATE `users` SET `first_name`=?,`last_name`=?,`email`=?,`tel`=? WHERE unid= ?");
        $insertData->bind_param("sssss",$editmemberFname,$editmemberLname,$editmemberEmail,$editMemberTel,$editMemberId);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "Data updated succesfully"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when updating Data"]); 
        }
    }else{
       
        echo json_encode(["success" => false, "message" => "User data not found"]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
if(isset($data['edittrainerDataStatus'])&& $data['edittrainerDataStatus']==true){
$edittrainerId = sanitize($data['edittrainerId']);
$edittrainerEmail = sanitize($data['edittrainerEmail']);
$edittrainerTel = sanitize($data['edittrainerTel']);
$edittrainerFname = sanitize($data['edittrainerFname']);
$edittrainerLname = sanitize($data['edittrainerLname']);
$stmt = $con->prepare("SELECT * FROM trainers WHERE `unid` = ? LIMIT 1");
$stmt->bind_param("s",$edittrainerId);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if($user){
        $insertData = $con->prepare("UPDATE `trainers` SET `first_name`=?,`last_name`=?,`email`=?,`tel`=? WHERE unid= ?");
        $insertData->bind_param("sssss",$edittrainerFname,$edittrainerLname,$edittrainerEmail,$edittrainerTel,$edittrainerId);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "Data updated succesfully"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when updating Data"]); 
        }
    }else{
       
        echo json_encode(["success" => false, "message" => "User data not found"]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
if(isset($data['blacklistmemberStatus'])&& $data['blacklistmemberStatus']==true){
$blacklistMemberId = sanitize($data['blacklistMemberId']);
$stmt = $con->prepare("SELECT * FROM users WHERE `unid` = ? LIMIT 1");
$stmt->bind_param("s",$blacklistMemberId);
$accountStatus = "blacklisted";
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if($user){
        if($user['accountStatus']=='active'){
            $insertData = $con->prepare("UPDATE `users` SET `accountStatus`=? WHERE unid= ?");
            $insertData->bind_param("ss",$accountStatus,$blacklistMemberId);
            if($insertData->execute()){
                echo json_encode(["success" => true, "message" => "Member blacklisted succesfully"]); 
            }else{
                echo json_encode(["success" => false, "message" => "error accured when blacklisting memeber"]); 
            }
        }else{
            echo json_encode(["success" => false, "message" => "Member is not active"]);
        }
    }else{
       
        echo json_encode(["success" => false, "message" => "User data not found"]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}

if(isset($data['whitelistmemberStatus'])&& $data['whitelistmemberStatus']==true){
$whitelistMemberId = sanitize($data['whitelistMemberId']);
$stmt = $con->prepare("SELECT * FROM users WHERE `unid` = ? LIMIT 1");
$stmt->bind_param("s",$whitelistMemberId);
$accountStatus = "active";
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if($user){
        if($user['accountStatus']=='blacklisted'){
            $insertData = $con->prepare("UPDATE `users` SET `accountStatus`=? WHERE unid= ?");
            $insertData->bind_param("ss",$accountStatus,$whitelistMemberId);
            if($insertData->execute()){
                echo json_encode(["success" => true, "message" => "Member whitelisted succesfully"]); 
            }else{
                echo json_encode(["success" => false, "message" => "error accured when whitelisting memeber"]); 
            }
        }else{
            echo json_encode(["success" => false, "message" => "Member is not blacklisted"]);
        }
    }else{
       
        echo json_encode(["success" => false, "message" => $whitelistMemberId]);
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}

if(isset($data['trainerregistrationStatus'])&& $data['trainerregistrationStatus']==true){
$trainerEmail = sanitize($data['trainerEmail']);
$trainerTel = sanitize($data['trainerTel']);
$trainerLname = sanitize($data['trainerLname']);
$trainerFname = sanitize($data['trainerFname']);
$level = sanitize($data['level']);
$unid = random_num(5);
$stmt = $con->prepare("SELECT * FROM trainers WHERE `email` = ? LIMIT 1");
$stmt->bind_param("s",$trainerEmail);
if($stmt->execute()){
    $results = $stmt->get_result();
    $user=$results->fetch_assoc();
    if($user){
        echo json_encode(["success" => false, "message" => "User data exists"]);
    }else{
       $insertData = $con->prepare("INSERT INTO trainers (`unid`, `first_name`, `last_name`, `tel`, `email`, `level`)VALUES(?,?,?,?,?,?)");
        $insertData->bind_param("ssssss",$unid,$trainerFname,$trainerLname,$trainerTel,$trainerEmail,$level);
        if($insertData->execute()){
            echo json_encode(["success" => true, "message" => "Trainer added succesfully"]); 
        }else{
            echo json_encode(["success" => false, "message" => "error accured when adding Trainer"]); 
        }
        
    }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}
?>