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
//ad group by so that each plan is in one row
$stmt = $con->prepare("SELECT
            plans.unid, 
            plans.name, 
            plans.duration_value, 
            plans.duration_type, 
            plans.tariff, 
            plans.discount,
            GROUP_CONCAT(plan_features.feature_text SEPARATOR '||') AS features
            FROM plans LEFT JOIN plan_features ON plan_features.plan_id = plans.unid GROUP BY plans.unid ORDER BY plans.unid asc");
$stmt->execute();
$arraData=array();
$results = $stmt->get_result();
    while($data=$results->fetch_assoc()){
        // convert features into array
        $data['features'] = $data['features'] ? explode("||", $data['features']) : [];
        $arraData[]=$data;
    }

echo json_encode(["success"=>true,"plan"=>$arraData]);
?>