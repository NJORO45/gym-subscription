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
<body id="flex flex-col">
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
                    
                    <a href="#" class="block px-4 py-2 hover:bg-gray-200 hover:text-orange-600">Profile</a>
                    <a href="settings.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-orange-600">Settings</a>
                    <a href="#"id="logoutBtn" class="block px-4 py-2 hover:bg-gray-200 hover:text-orange-600">Logout</a>
                </div>
               </div>
            </a>
        </div>
    </div>
   </nav>
   <!--firstsection-->
   <div class="flex-grow pt-16 flex flex-col place-items-center px-4 space-y-2 border-b-2 pb-4">
    <div class="flex flex-col space-y-2 shadow-lg rounded-lg p-2">
        <!--personal details-->
        <h2 class="text-sm font-bold mb-2">Personal Info</h2>
        <input id="csrtftokenProfile" class="csrtfToken" type="text" value="" hidden >
        <div class="flex flex-col sm:flex-row gap-2">
            <label for=""> First name</label>
            <input id="Fname" class="border-2 rounded-lg outline-none px-2 py-1" type="text">
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <label for=""> Last name</label>
            <input id="Lname" class="border-2 rounded-lg outline-none px-2 py-1" type="text">
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <label for="">Tel</label>
            <input id="tel" class="border-2 rounded-lg outline-none px-2 py-1" type="text">
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <label for="">Email</label>
            <input id="email" class="border-2 rounded-lg outline-none px-2 py-1" type="text">
        </div>
        <div class="flex justify-center">
            <button id="saveBtn" class="bg-orange-400 px-2 py-1 text-white rounded-full text-sm hover:bg-orange-600">Save changes</button>
        </div>
    </div>
    <div class="flex flex-col space-y-2 shadow-lg rounded-lg p-2">
        <h2 class="text-sm font-bold">Other Details</h2>
        <div class="flex flex-col gap-2">
            <label for="" class="text-gray-900">📅 Joined Date</label>
            <p id="joinDate" class="text-gray-600 text-sm">2025/08/16 14:40:09</p>
        </div>
        <div>
            <label for="" class="text-gray-900">💳 Subscription</label>
            <p class="text-gray-600 text-sm">N/A</p>

        </div>
        <div>
            <label for="" class="text-gray-900">Subscription Status</label>
            <p class="space-y-2">
                <p class="text-gray-600  text-sm ">Next payment Due</p>
                <span class="text-gray-600  text-sm ">N/A</span>
            </div>
    </div>
    <div class="w-full flex mx-auto flex-col">
        <p class="text-sm font-bold text-center">View payment history</p>
        <div class="w-full overflow-auto shadow-xl rounded-lg max-h-[300px] place-items-center">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-sm bg-gray-200 text-gray-500 p-2 whitespace-nowrap sticky left-0 top-0 z-[25] ">Receipt no.</th>
                        <th class="text-sm bg-gray-200 text-gray-500 p-2 whitespace-nowrap sticky  top-0 z-20">amount</th>
                        <th class="text-sm bg-gray-200 text-gray-500 p-2 whitespace-nowrap sticky top-0 z-20">Date</th>
                        <th class="text-sm bg-gray-200 text-gray-500 p-2 whitespace-nowrap sticky  top-0 z-20">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2 ">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                    <tr class="space-x-2">
                        <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">RTHOS87YU</td>
                        <td class="p-2 whitespace-nowrap ">kes 2000</td>
                        <td class="p-2 whitespace-nowrap ">2025/05/09</td>
                        <td colspan="2">
                            <button class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</button>
                        </td>
                    </tr>
                </tbody>
            </table>
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
                <p class="text-gray-500">A reset link will be sent to the above email if a match is found</p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Reset password</button>
        </div>
    </div>
</div>
</body>
<script src="../js/session_statusmain.js"></script>
<script src="../js/mainmain.js"></script>
<script src="../js/csrfmain.js"></script>
<script src="../js/profile.js"></script> 
<script src="../js/logoutmain.js"></script>
</html>