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
<body>
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
            <a href="#">Smart gym Admin</a>
        </div>
        <!--humbarger-->
        <div>
            <i class="ri-menu-3-line text-orange-400 text-3xl cursor-pointer"></i>
        </div>
    </div>
   </nav>
<!--sidebar-->
<div class="hidden z-40 h-screen w-full sm:w-64 -left-64 bg-gray-100 mt-14 sm:mt-16 text-center">
    <ul class="flex flex-col gap-2 ">
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Home</a></li>
        <li><a href="#">Members</a></li>
        <li><a href="#">rates</a></li>
        <li><a href="#">Home</a></li>
    </ul>
</div>
<!--main container-->
<div class="flex flex-col gap-4 pt-20 sm:pt-20  mx-4 pb-6">
    <!--cards-->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 place-items-center mt-8">
        <div class="w-full bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center transition transform hover:scale-105 ">
            <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-500 rounded-full mb-3">
                <i class="ri-group-fill text-2xl"></i>
            </div>
            <h2 class="text-sm text-gray-600 font-semibold">Active members</h2>
            <span class="text-2xl font-bold text-gray-800">150</span>
        </div>
        <div class="w-full bg-white flex flex-col items-center shadow-lg rounded-2xl p-6 transition transform hover:scale-105">
            <div class="w-12 h-12 bg-blue-100 text-blue-500 flex items-center justify-center rounded-full mb-3">
                <i class="ri-price-tag-3-fill text-2xl"></i>
            </div>
            <h2 class="text-gray-600 text-sm font-semibold">Subscriptions</h2>
            <span class="text-2xl font-bold text-gray-800">120</span>
        </div>
        <div class="w-full flex flex-col items-center shadow-lg rounded-2xl p-6 transition transform hover:scale-105">
            <div class="w-12 h-12 bg-blue-100 text-blue-500 rounded-full mb-3 flex justify-center items-center">
                <i class="ri-money-dollar-circle-fill text-2xl"></i>
            </div>
            <h2 class="text-gray-600 font-semibold text-sm">Monthly revenue</h2>
            <span class="text-gray-800 font-bold text-2xl">KES 15,000</span>
        </div>
        <div class="w-full flex flex-col rounded-2xl shadow-lg p-6 items-center transform transition hover:scale-105">
            <div class="w-12 h-12 flex justify-center items-center bg-blue-100 text-blue-500 mb-3 rounded-full">
                <i class="ri-user-star-fill text-2xl"></i>
            </div>
            <h2 class="text-gray-600 text-sm font-semibold">Trainers</h2>
            <span class="text-gray-800 font-bold text-2xl">8</span>
        </div>
        <div class="w-full flex flex-col rounded-2xl shadow-lg p-6 items-center transform transition hover:scale-105">
            <div class="w-12 h-12 flex justify-center items-center bg-blue-100 text-blue-500 mb-3 rounded-full">
                <i class="ri-timer-fill text-2xl"></i>
            </div>
            <h2 class="text-gray-600 text-sm font-semibold">Expiring Soon</h2>
            <span class="text-gray-800 font-bold text-2xl">8</span>
        </div>
        <div class="w-full flex flex-col rounded-2xl shadow-lg p-6 items-center transform transition hover:scale-105">
            <div class="w-12 h-12 flex justify-center items-center bg-blue-100 text-blue-500 mb-3 rounded-full">
                <i class="ri-calendar-check-fill text-2xl"></i>
            </div>
            <h2 class="text-gray-600 text-sm font-semibold">Atendance Today</h2>
            <span class="text-gray-800 font-bold text-2xl">8</span>
        </div>
    </div>
   
    <!--recent member list-->
    <div class="w-full mx-auto pt-6 ">
        <h2 class="text-center text-gray-600 font-bold">Recent Members</h2>
        <div class="w-full overflow-auto   rounded-lg shadow-xl ">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="bg-gray-100 p-2 text-gray-500">No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Member</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Package</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Date</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Date</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Date</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Date</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Date</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">1</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">Samuel Joe</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">free trial</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">2025/08/25</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">2025/08/25</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">2025/08/25</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">2025/08/25</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">2025/08/25</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
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
</body>
</html>