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
<div class="hidden z-40 h-[calc(100vh-3.5rem)] w-full sm:w-64 overflow-y-auto  bg-gray-100 top-14 sm:top-16 text-center ">
    <ul class="flex flex-col gap-2 ">
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Dashboard</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Members</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Subscriptions/Plans</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Payments</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Trainers</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Attendance</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Reports</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Settings</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Logout</a></li>
    </ul>
</div>
<!--main container-->
<div class="flex flex-col gap-4 pt-20 sm:pt-20  mx-4 pb-6">
    
    <!--recent member list-->
    <div class="w-full mx-auto pt-0">
        <div class="flex justify-between">
            <h2 class=" text-gray-600 font-bold w-full text-center">Subscription tarifs</h2>
            <i class="ri-add-fill text-orange-400 text-2xl font-bold transform transition hover:scale-105 hover:-translate-y-1 cursor-pointer hover:text-orange-600"></i>
        </div>
        <div class="w-full overflow-auto   rounded-lg shadow-xl ">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="bg-gray-100 p-2 text-gray-500">No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Plan</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Duration</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Tarrif</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">1</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">Free trial</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">30 days</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">0.0</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center">
                            <input class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="Edit">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--add plan pupup form-->
<div class="fixed z-40 inset-0 bg-black/50   hidden justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Add plan</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Plan name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Duration</label>
                <input type="email" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Price</label>
                <input type="text" placeholder="your tel" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Save & confirm</button>
        </div>
    </div>
</div>
<!--edit plan pupup form-->
<div class="fixed z-40 inset-0 bg-black/50 hidden   justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Edit plan</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Plan name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Duration</label>
                <input type="email" placeholder="your email" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Price</label>
                <input type="text" placeholder="your tel" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Save & confirm</button>
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