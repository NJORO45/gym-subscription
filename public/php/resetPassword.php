<?php
session_start();
include("db_connect.php");

if (isset($_GET['token'])) {
   // Look for user with this token
   
   $token=$_GET['token'];
    $stmt = $con->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $_SESSION['reset_user_id'] = $user['unid']; // store user ID in session
    } else {
        die("Invalid or expired token.");
    }

} else {
    // header("Location:../index.html");
    // exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../main.css">
        <!--favicon -->
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"  />
    </head>
</head>
<body class="bg-gray-100">
    <!--alert message-->
   <div id="alertMessage" class="fixed z-50 left-1/2 -translate-x-1/2 bg-red hidden bg-orange-300 mt-2 rounded-lg shadow-xl px-3 py-1 gap-1 ">
       <i class="ri-error-warning-fill text-xl"></i>
       <p>alert message</p>
   </div>
    <div class="w-full h-screen flex justify-center items-center">
        <div class="max-w-sm w-full bg-slate-100 rounded-lg shadow-xl p-6 space-y-4 mx-2">
            <h2 class="text-center font-bold text-orange-500 text-xl">Reset password</h2>
            <div class="flex flex-col gap-2">
                <label for="">New password</label>
                <div class="relative">
                    <input id="password" type="password" class="rounded-lg outline-none px-2 py-1 w-full"/>
                    <i id="view" class="ri-eye-off-line absolute top-1 right-2 text-lg"></i>
                </div>
                <p class="text-xs text-gray-500">At least 8 characters, 1 uppercase, 1 number.</p>
                <p id="passwordError" class="text-xs text-red-500"></p>
            </div>
            <div class="flex flex-col gap-2">
                <label for="">Confirm New password</label>
                <div class="relative">
                    <input id="newPassword" type="password" class="rounded-lg outline-none px-2 py-1 w-full"/>
                    <i id="view" class="ri-eye-off-line absolute top-1 right-2 text-lg"></i>
                    <input id="userresetPasswordcsrtToken" class="csrtfToken" type="text" value="<?php echo $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); ?>" hidden >
                </div>
                <p id="ConfirmpasswordError" class="text-xs text-red-500"></p>
            </div>
            <div class="w-full">
                <button id="resetPasswordBtn" class="bg-orange-400 w-full text-white rounded-lg p-2 hover:bg-orange-600 cursor pointer">Reset password</button>
            </div>
        </div>
    </div>
</body>
<script src="../js/resetPassword.js"></script>
</html>