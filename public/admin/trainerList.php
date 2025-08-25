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
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="admin.php">Dashboard</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="">Members</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Subscriptions/Plans</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Payments</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Trainers</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Attendance</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Blacklist</a></li>
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
            <h2 class=" text-gray-600 font-bold w-full text-center">Trainers List</h2>
            <i class="ri-add-fill text-orange-400 text-2xl font-bold transform transition hover:scale-105 hover:-translate-y-1 cursor-pointer hover:text-orange-600"></i>
        </div>
        <div class="w-full overflow-auto   rounded-lg shadow-xl ">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="bg-gray-100 p-2 text-gray-500">No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Trainer No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Fist Name</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Last Name</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Tel</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Email</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Id No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Level</th>
                        <th class="bg-gray-100 p-2 text-gray-500">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">1</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">369</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">John</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">Doe</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">0717109687</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">@gmail.com</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900">3585579</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">black belt</td>
                        <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center flex flex-row gap-2">
                            <input class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="Edit">
                            <input class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="Blacklist">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--blacklist pupup form-->
<div class="fixed z-40 inset-0 bg-black/50   hidden justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Add to blacklist</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Trainer number</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">First name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg " readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Last Name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Add to blackList</button>
        </div>
    </div>
</div>
<!--edit member detils pupup form-->
<div class="fixed z-40 inset-0 bg-black/50   hidden justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Edit Details</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Trainer number</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" >
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">First name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg " >
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Last Name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" >
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" >
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Save Changes</button>
        </div>
    </div>
</div>
<!--add new member pupup form-->
<div class="fixed z-40 inset-0 bg-black/50   hidden justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Add New Trainer</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Trainer number</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">First name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg " readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Last Name</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Add New Trainer</button>
        </div>
    </div>
</div>
</body>
</html>