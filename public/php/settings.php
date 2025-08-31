<?php
session_start();

if (isset($_SESSION['user_id'])) {
   
} else {
    header("Location:../index.html");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
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
<body class="flex flex-col">
   <!--alert message-->
   <div id="alertMessage" class="fixed z-50 left-1/2 -translate-x-1/2 bg-red hidden bg-orange-300 mt-2 rounded-lg shadow-xl px-3 py-1 gap-1 ">
       <i class="ri-error-warning-fill text-xl"></i>
       <p>alert message</p>
   </div>
   <!--navbar-->
   <nav class="fixed z-30  bg-gray-100 text-blue-700 h-14 sm:h-16 w-full shadow-md">
    <div class="flex flex-row h-full w-full items-center justify-between px-4 py-2">
        <!--logo/brand-->
        <div class=" font-bold tracking-wide text-ms sm:text-xl">
            <a href="../index.html">Smart gym</a>
        </div>
        <!--links-->
        <div class="flex flex-row items-center gap-1 sm:gap-6 text-sm sm:text-lg">
            <a href="../index.html" class="relative py-2 text-orange-500  after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full ">Home</a>
            <a href="#" class="relative py-2 before:absolute before:bottom-0 before:left-1/2 before:h-[2px] before:w-0 before:bg-blue-600 before:transition-all before:duration-300 hover:before:left-0 hover:before:w-full hidden">Contact</a>
            <a href="#" class="relative py-2  before:absolute before:bottom-0 before:left-1/2 before:h-[2px] before:w-0 before:bg-blue-600 before:transition-all before:duration-300 hover:before:left-0 hover:before:w-full hidden">About </a>
            <a href="#" id="userLogin" class="flex  items-center  gap-2 font-semibold bg-orange-500 ml-1 sm:ml-4 px-2 py-1 sm:px-4 sm:py-2 shadow-md hover:shadow-lg rounded-md text-white hover:bg-orange-600 transition-all">
                <i class="ri-login-circle-line text-lg"></i>
                <div  class=" hidden sm:block">Login</div>
            </a>
            <a href="#" id="userprofile" class="hidden relative ">
               <div id="userProfileContainer"  class=" relative items-center  gap-2 font-semibold bg-orange-500 ml-1 sm:ml-4 px-2 py-1 sm:px-4 sm:py-2 shadow-md hover:shadow-lg rounded-md text-white hover:bg-orange-600 transition-all">
                 <i class="ri-user-line"></i>
                <i class="ri-arrow-down-s-line text-lg"></i>
               </div>
               <div  class=" absolute flex flex-col right-2 top-2 ">
                <div class="block absolute shadow-xl bg-gray-100 w-6 h-6 right-[35px] top-12 -rotate-45"></div>
                  <!-- Dropdown menu -->
                <div id="profileDropdown" class=" hidden absolute   w-max h-max bg-gray-100 shadow-lg rounded-md overflow-hidden flex-col right-2 top-[49px]  text-left z-40">
                    
                    <a href="profile.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-orange-600">Profile</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-orange-600">Settings</a>
                    <a href="#"id="logoutBtn" class="block px-4 py-2 hover:bg-gray-200 hover:text-orange-600">Logout</a>
                </div>
               </div>
            </a>
        </div>
    </div>
   </nav>
   <!--firstsection-->
   <div class="flex-grow pt-16 grid grid-cols-1 sm:grid-cols-1 place-items-center px-4 space-y-2 border-b-2 pb-4">
    <div class=" flex flex-col space-y-2 shadow-lg rounded-lg p-2">
        <!--personal details-->
        <h2 class="text-lg text-center font-bold mb-2">Account Security</h2>
        <input id="csrtftokenpaswordReset" class="csrtfToken" type="text" value="" hidden >
        <div class="flex flex-col sm:flex-row gap-2 justify-between">
            <label for="">Old password</label>
            <input id="oldPassword" class="border-2 rounded-lg outline-none px-2 py-1" type="password">
            <p id="oldpassError" class="text-red-500 text-xs font-semibold"></p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 justify-between">
            <label for="">New password</label>
            <input id="newPassword" class="border-2 rounded-lg outline-none px-2 py-1" type="password">
            <p id="newpassError" class="text-red-500 text-xs font-semibold"></p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 justify-between">
            <label for="">Confirm New Password</label>
            <input id="ConfirmNewPassword" class=" border-2 rounded-lg outline-none px-2 py-1" type="password">
            <p id="confirmpassError" class="text-red-500 text-xs font-semibold"></p>
        </div>
        <div class="flex justify-center">
            <button id="changePasswordBtn" class="bg-orange-400 px-2 py-1 text-white rounded-full text-sm hover:bg-orange-600">Change Password</button>
        </div>
    </div>
    <div class="flex flex-col space-y-2 shadow-lg rounded-lg p-2">
        <h2 class="text-lg font-bold text-center">Preferences</h2>
        <div>
            <h1>Notification Preferences (SMS/email reminders)</h1>
            <div>
                <input id="csrtftokenpreference" class="csrtfToken" type="text" value="" hidden >
                <div>
                    <input type="radio" id="Selectedsms" name="notification" value="sms">
                    <label for="SMS" >SMS</label>
                </div>
                <div>
                    <input type="radio" id="Selectedemail" name="notification" value="email">
                    <label for="Email" >Email</label>
                </div>
            </div>
            <div class="flex justify-center">
            <button id="saveOptionBtn" class="bg-orange-400 px-2 py-1 text-white rounded-full text-sm hover:bg-orange-600">Save option</button>
        </div>
        </div>
    </div>
    <div class="flex flex-col space-y-2 shadow-lg rounded-lg p-2">
        <h2 class="text-lg text-center font-bold">Danger Zone</h2>
        <div class="text-red-500 p-4 hover:text-red-800">
           <button id="deleteAccountBtn">Deactivate/Delete Account</button>
        </div>
    </div>
    </div>
    <!--back to top-->
<div id="backToTopBtn" class="hidden fixed bottom-6 right-6 bg-orange-400 shadow-xl rounded-full z-30  w-8 h-8 flex justify-center items-center cursor-pointer hover:bg-orange-600 transition duration-100 ease-in-out">
    <i class="ri-arrow-up-double-fill text-xl text-white"></i>
</div>
   
   <!--footer-->  
   <div class="grid grid-cols-1  sm:grid-cols-3 px-6 py-4 gap-2">
    <div class="justify-items-center">
        <h1 class="text-lg font-semibold text-orange-400 mt-2">Socials</h1>
        <ul class="flex gap-4">
            <a href="#"><i class="ri-twitter-x-fill inline-block text-xl transform transition duration-200 hover:scale-110 hover:text-orange-600 hover:-translate-y-1"></i></a>
            <a href="#"><i class="ri-youtube-line inline-block text-xl transform transition duration-200 hover:scale-110 hover:text-orange-600 hover:-translate-y-1"></i></a>
            <a href="#"><i class="ri-whatsapp-line inline-block text-xl transform transition duration-200 hover:scale-110 hover:text-orange-600 hover:-translate-y-1"></i></a>
            <a href="#"><i class="ri-facebook-fill inline-block text-xl transform transition duration-200 hover:scale-110 hover:text-orange-600 hover:-translate-y-1"></i></a>
            <a href="#"><i class="ri-telegram-2-fill inline-block text-xl transform transition duration-200 hover:scale-110 hover:text-orange-600 hover:-translate-y-1"></i></a>
            <a href="#"><i class="ri-instagram-line inline-block text-xl transform transition duration-200 hover:scale-110 hover:text-orange-600 hover:-translate-y-1"></i></a>
        </ul>
    </div>
    <div class="justify-items-center">
        <h1 class="text-lg font-semibold text-orange-400 mb-2">Contacts</h1>
        <div>
            <p>📧 smartgym@gmail.com</p>
            <p>📞 +254717700554</p>
        </div>
    </div>
    <div class="justify-items-center">
        <p>Stay Updated</p>
        <div class="flex flex-col ">
            <input type="email" placeholder="Your email" class="outline-none py-2 px-1 border-2 border-gray-200 my-2 rounded-md">
            <button class="bg-orange-500 px-4 py-2 text-white hover:bg-orange-600 rounded-full">Subscribe</button>
        </div>
        <p class="mt-4 cursor-pointer text-blue-700">💡 Drop a suggestion anytime!</p>
    </div>
   </div>

<!--suggestion box pupup form-->
<div class="hidden fixed z-40 inset-0 bg-black/50   justify-center  h-full pb-2 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-64 mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="cross" class="ri-close-large-line inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold">💡 Suggestion Box</h2>
        <div class="flex flex-col space-y-6">
            <input class="csrtfToken" type="text" value="" hidden >
            <textarea class="border rounded-lg p-2 outline-none resize-none" name="" id="" rows="4" placeholder="Write your suggestion here .."></textarea>
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white ">Submit</button>
        </div>
    </div>
</div>
<!--register pupup form-->
<div id="signupPopup" class="fixed z-40 inset-0 bg-black/50 hidden  justify-center h-full pb-2 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="cross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Sign up</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">First Name</label>
                <input id="Fname" type="text" placeholder="your First Name" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p id="fNameError" class=" text-red-500 font-semibold"></p>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Last Name</label>
                <input id="Lname" type="text" placeholder="your Last name" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p id="lNameError" class=" text-red-500 font-semibold"></p>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input id="signupemail" type="email" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p id="signupEmailError" class=" text-red-500 font-semibold"></p>
                <input id="signupcsrtToken" class="csrtfToken" type="text" value="" hidden >
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Tel</label>
                <input id="tel" type="text" placeholder="your tel" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p id="telError" class=" text-red-500 font-semibold"></p>
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Password</label>
                <input id="signupPassword" type="text" placeholder="your password" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p id="signuppasswordError" class=" text-red-500 font-semibold"></p>
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Confirm Password</label>
                <input id="confirmPassword" type="text" placeholder="Confirm password" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p id="passwordConfirmError" class=" text-red-500 font-semibold"></p>
            </div>
            <div>
                <p class="text-gray-500">Are you a member? <a class="text-blue-700 cursor-pointer" id="loginLink">login</a></p>
                <p class="text-gray-500">Admin <a class="text-md text-blue-700 cursor-pointer" id="adminLoginLink">login</a></p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button id="signupBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Sign up</button>
        </div>
    </div>
</div>
<!--login pupup form-->
<div id="loginPopup" class="fixed z-40 inset-0 bg-black/50 hidden  justify-center h-full overflow-y-auto pb-2">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="cross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Login</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="email" placeholder="your email" id="loginEmail" class="border-2 outline-none px-2 py-1 rounded-lg">
                <input id="logincsrtfToken" class="csrtfToken" type="text" value="" hidden >
                <p id="loginEmailError" class="hidden text-red-500 font-semibold">No match</p>
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Password</label>
                <input type="password" placeholder="Your password" id="loginPassword" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p id="loginPassError" class="hidden text-red-500 font-semibold">No match</p>
            </div>
            <div>
                <p class="text-gray-500">Not a member? <a class="text-blue-700 cursor-pointer" id="signupLink">sign up</a></p>
                 <a class="text-blue-700 cursor-pointer underline" id="resetPassword">Forgot password</a>
                <p class="text-gray-500">Admin <a class="text-md text-blue-700 cursor-pointer" id="adminLoginLink">login</a></p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button id="loginBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Login</button>
        </div>
    </div>
</div>
<!--admin pupup form-->
<div id="adminLogin" class="fixed z-40 inset-0 bg-black/50 hidden  justify-center  h-full pb-2 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="cross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Admin</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
                <input class="csrtfToken" type="text" value="" hidden >
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Password</label>
                <input type="text" placeholder="Confirm password" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p class="hidden text-red-500 font-semibold">No match</p>
            </div>
            <div>
                <p class="text-gray-500">Not a member? <a class="text-blue-700 cursor-pointer" id="signupLink">sign up</a></p>
                <p class="text-gray-500">Are you a member? <a class="text-blue-700 cursor-pointer" id="loginLink">login</a></p>
                 <a class="text-blue-700 cursor-pointer underline" id="adminForgetPassword">Forgot password</a>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Login</button>
        </div>
    </div>
</div>
<!--admin forget password pupup form-->
<div id="adminresetPassword" class="fixed z-40 inset-0 bg-black/50 hidden  justify-center  h-full pb-2 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="cross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Admin</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
                <input class="csrtfToken" type="text" value="" hidden >
            </div>
            <div>
                <p class="text-gray-500">A reset link will be sent to the above email if a match is found</p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Reset password</button>
        </div>
    </div>
</div>
<!--user forget password pupup form-->
<div id="userresetPassword" class="fixed z-40 inset-0 bg-black/50 hidden  justify-center  h-full pb-2 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="cross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">User</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
                <input class="csrtfToken" type="text" value="" hidden >
            </div>
            <div>
                <input id="deactivatecsrtToken" class="csrtfToken" type="text" value="" hidden >
                <p class="text-gray-500">A reset link will be sent to the above email if a match is found</p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Reset password</button>
        </div>
    </div>
</div>
<div id="deactivateAccount" class="fixed z-40 inset-0 bg-black/50 hidden  justify-center  h-full pb-2 overflow-y-auto">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="cross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-lg">Deactivate/Delete Account</h2>
        <div class="space-y-2">
            <div>
                <p class="text-red-500 text-center py-4">Are you sure you want to delete/deactivate your account</p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button id="deactivateTrue" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Yes</button>
        </div>
    </div>
</div>
</body>
<script src="../js/session_statusmain.js"></script>
<script src="../js/mainmain.js"></script>
<script src="../js/csrfmain.js"></script>
<script src="../js/logoutmain.js"></script>
<script src="../js/settings.js"></script>
</html>