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
$response = [
    "loggedIn"=>false,
    "hasPlan"=>false
];
if(isset($_SESSION['user_id'])){
    //check if any plan was sabscribed
    $plan=$con->prepare("SELECT plan_unid,plan_name,expiryDate FROM plansubscription WHERE user_unid= ? LIMIT 1");
    $unid = $_SESSION['user_id'];
    $plan->bind_param("s",$unid);
    $plan->execute();
    $result = $plan->get_result();
    if($result->num_rows>0){
        $data=$result->fetch_assoc();
         $expiryDate = new DateTime($data['expiryDate']); // from DB
         $now = new DateTime("now", new DateTimeZone("Africa/Nairobi")); // current time
        if($expiryDate > $now){
            //not expired
            $response["hasPlan"] = true;
            $response["expiryDate"] =$data['expiryDate'];
            $response["plan_name"] =$data['plan_name'];
            $response["message"] = "subscribed to:"." ".$data['plan_name']." "."plan";
        }else{
            //expired
            $response["hasPlan"] = false;
            
        }
        
    }else{
         $response["hasPlan"] = false;
    }
    $response["loggedIn"] = true;
    
}
echo json_encode($response);
?>