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
<body class="flex flex-col min-h-screen">
   <!--alert message-->
   <div class="fixed z-50 left-1/2 -translate-x-1/2 bg-red flex bg-orange-300 mt-2 rounded-lg shadow-xl px-3 py-1 gap-1 animate-slide-down ">
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
            <a href="#" class="relative py-2 text-orange-500  after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-full after:bg-orange-500">Home</a>
            <a href="#" class="relative py-2 before:absolute before:bottom-0 before:left-1/2 before:h-[2px] before:w-0 before:bg-blue-600 before:transition-all before:duration-300 hover:before:left-0 hover:before:w-full">Contact</a>
            <a href="#" class="relative py-2  before:absolute before:bottom-0 before:left-1/2 before:h-[2px] before:w-0 before:bg-blue-600 before:transition-all before:duration-300 hover:before:left-0 hover:before:w-full">About </a>
            <a href="#" class="flex items-center  gap-2 font-semibold bg-orange-500 ml-1 sm:ml-4 px-2 py-1 sm:px-4 sm:py-2 shadow-md hover:shadow-lg rounded-md text-white hover:bg-orange-600 transition-all">
                <i class="ri-login-circle-line text-lg"></i>
                <div class=" hidden sm:block">Login</div>
            </a>
        </div>
    </div>
   </nav>
   
<!--payment methods-->
<div class="mt-20 w-full border-b-2 pb-4">
<div class="flex-grow max-w-md md:max-w-xl mx-auto bg-white p-6 rounded-2xl shadow-lg">
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800 mb-3">💳 payment methods</h1>
        <div class="space-y-2">
            <div class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                <input type="checkbox" name="" id="" class="w-4 h-4 rounded-full  text-orange-500 focus:ring-orange-400">
                <span class="text-gray-700">Mpesa</span>
            </div>
            <div class="flex items-center gap-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                <input type="checkbox" name="" id="" class="w-4 h-4 rounded-full  text-orange-500 focus:ring-orange-400">
                <span class="text-gray-700">Credit / Debit Card</span>
            </div>
        </div>
    </div>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800 mb-3">📅 Subscription</h1>
        <div class="bg-gray-50 p-4 rounded-lg border space-y-2 text-gray-700">
            <p><span class="font-medium text-gray-800">Type:</span><span>monthly</span></p>
            <p><span class="font-medium text-gray-800">Amount:</span><span>ksh 1,500</span></p>
            <p><span class="font-medium text-gray-800">Expiry:</span><span>20th Sept 2025</span></p>
        </div>
    </div>
    <button class="w-full bg-orange-400 px-3 py-1 rounded-full text-white hover:bg-orange-600">Pay now</button>
</div>
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
</body>
<!--suggestion box pupup form-->
<div class="hidden fixed z-40 inset-0 bg-black/50   justify-center">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-64 mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold">💡 Suggestion Box</h2>
        <div class="flex flex-col space-y-6">
            <textarea class="border rounded-lg p-2 outline-none resize-none" name="" id="" rows="4" placeholder="Write your suggestion here .."></textarea>
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white ">Submit</button>
        </div>
    </div>
</div>
<!--register pupup form-->
<div class="fixed z-40 inset-0 bg-black/50 hidden  justify-center">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Sign up</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="email" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Tel</label>
                <input type="text" placeholder="your tel" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Password</label>
                <input type="text" placeholder="your password" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Confir Password</label>
                <input type="text" placeholder="Confirm password" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p class="hidden text-red-500 font-semibold">No match</p>
            </div>
            <div>
                <p class="text-gray-500">Are you a member? <a class="text-blue-700 cursor-pointer">login</a></p>
                <p class="text-gray-500">Admin <a class="text-md text-blue-700 cursor-pointer">login</a></p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Sign up</button>
        </div>
    </div>
</div>
<!--login pupup form-->
<div class="fixed z-40 inset-0 bg-black/50 hidden  justify-center">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Login</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Password</label>
                <input type="text" placeholder="Confirm password" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p class="hidden text-red-500 font-semibold">No match</p>
            </div>
            <div>
                <p class="text-gray-500">Not a member? <a class="text-blue-700 cursor-pointer">sign up</a></p>
                 <a class="text-blue-700 cursor-pointer underline">Forgot password</a>
                <p class="text-gray-500">Admin <a class="text-md text-blue-700 cursor-pointer">login</a></p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Login</button>
        </div>
    </div>
</div>
<!--admin pupup form-->
<div class="fixed z-40 inset-0 bg-black/50 hidden  justify-center">
    <div class="bg-white rounded-xl w-full max-w-md md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Admin</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
             <div class="flex flex-col w-full gap-4">
                <label for="">Password</label>
                <input type="text" placeholder="Confirm password" class="border-2 outline-none px-2 py-1 rounded-lg">
                <p class="hidden text-red-500 font-semibold">No match</p>
            </div>
            <div>
                <p class="text-gray-500">Not a member? <a class="text-blue-700 cursor-pointer">sign up</a></p>
                <p class="text-gray-500">Are you a member? <a class="text-blue-700 cursor-pointer">login</a></p>
                 <a class="text-blue-700 cursor-pointer underline">Forgot password</a>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Login</button>
        </div>
    </div>
</div>
</html>