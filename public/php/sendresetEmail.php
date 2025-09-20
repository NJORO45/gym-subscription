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

require __DIR__ .'/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

//point it to where .env exists
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$data = json_decode(file_get_contents("php://input"), true);
// CSRF check
if (!$data || !isset($data['csrtfToken']) || $data['csrtfToken'] !== $_SESSION['csrf_token']) {
    echo json_encode(["success" => false, "message" => !$data ? "Invalid JSON" : "CSRF validation failed" . $_SESSION['csrf_token']]);
    exit;
}

if(isset($data['userResetStatus'])&& $data['userResetStatus']==true){
$email = sanitize($data['userResetEmail']);
$stmt = $con->prepare("SELECT unid, email FROM users WHERE `email` = ? LIMIT 1");
$stmt->bind_param("s",$email);
if($stmt->execute()){
    $results = $stmt->get_result();
    
 if($results->num_rows==1){
   $user=$results->fetch_assoc();
   //Generate secure reset token
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); 

    // Save token in DB
    $update = $con->prepare("UPDATE users SET reset_token=?, reset_expiry=? WHERE unid=?");
    $update->bind_param("sss", $token, $expiry, $user['unid']);
    $update->execute();

    // Create reset link
    $resetLink = "http://localhost:8000/project/gym%20subscription/public/php/resetPassword.php?token=".$token;

    try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_email']; // must be full Gmail address
    $mail->Password   = $_ENV['SMTP_PASSWORD'];       // Gmail App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('wavetonsolutions@gmail.com', 'Waveton Solutions');
    $mail->addAddress($email, 'Client Name'); 

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Request';
    $mail->Body    = "
                    <h2>Password Reset</h2>
                    <p>Hello,</p>
                    <p>Click the link below to reset your password. This link is valid for <b>1 hour</b>.</p>
                    <p><a href='$resetLink'>$resetLink</a></p>
                    <p>If you did not request a reset, ignore this email.</p>
                ";
                $mail->AltBody = "Password reset link: $resetLink";

    $mail->send();
    echo json_encode(["success" => true, "message" => "✅ Email has been sent "]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    
}

 }else{
    //echo json_encode(["success" => false, "message" => "Login successful"]);
 }
}else{
    echo json_encode(["success" => false, "message" => "Database error"]);
}
}

?>