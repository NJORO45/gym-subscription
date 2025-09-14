<?php
session_start();

if (isset($_SESSION['admin_user_id'])) {
   
} else {
    header("Location:../index.html");
    exit;
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

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
<body>
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
            <a href="#">Smart gym Admin</a>
        </div>
        <!--humbarger-->
        <div  class="cursor-pointer">
            <i id="humbarger" class=" w-full ri-menu-3-line text-orange-400 text-3xl"></i>
        </div>
    </div>
   </nav>
<!--sidebar-->
<div id="humbargerMenu" class="fixed z-40 h-[calc(100vh-3.5rem)] w-full sm:w-64 -left-full sm:-left-64 overflow-y-auto  bg-gray-100 top-14 sm:top-16 text-center trasnsition-all duration-500 ease-in-out">
    <ul class="flex flex-col gap-2 ">
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="admin.php">Dashboard</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="members.php">Members</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Subscriptions/Plans</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="payments.php">Payments</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="trainerList.php">Trainers</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="attendanceList.php">Attendance</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Reports</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Settings</a></li>
        <li id="adminlogout" class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Logout</a></li>
    </ul>
</div>
<!--main container-->
<input id="adminCsrfToken" value="<?php echo $_SESSION['csrf_token'];?>" hidden>
<div class="flex flex-col gap-4 pt-20 sm:pt-20  mx-4 pb-6">
    
    <!--recent member list-->
    <div class="w-full mx-auto pt-0">
        <div class="flex justify-between">
            <h2 class=" text-gray-600 font-bold w-full text-center">Subscription tarifs</h2>
            <i id="addplanPopup" class="ri-add-fill text-orange-400 text-2xl font-bold transform transition hover:scale-105 hover:-translate-y-1 cursor-pointer hover:text-orange-600"></i>
        </div>
        <div class="w-full overflow-auto   rounded-lg shadow-xl ">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="bg-gray-100 p-2 text-gray-500 text-left">No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500 text-left">Plan</th>
                        <th class="bg-gray-100 p-2 text-gray-500 text-left">Duration</th>
                        <th class="bg-gray-100 p-2 text-gray-500 text-left">Tarrif</th>
                        <th class="bg-gray-100 p-2 text-gray-500 text-left">Discount Tarrif</th>
                        <th class="bg-gray-100 p-2 text-gray-500 text-left">Discount</th>
                        <th class="bg-gray-100 p-2 text-gray-500 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="bg-gray-50 p-2 text-sm text-gray-900">fetching data....</td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--add plan pupup form-->
<div id="addPlan" class="fixed z-40 inset-0 bg-black/50 flex hidden  overflow-y-auto   justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="addPlancross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Add plan</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Plan name</label>
                <input id="planeName" type="text" placeholder="Plan name" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4 ">
                <label for="">Duration</label>
                <select name="" id="DurationOption" class="border-2 text-md">
                    <option value="default" default>--select--</option>
                    <option value="day">Day</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <div class="flex flex-col w-full gap-2">
                <label for="">Plan Features</label>

                <!-- Container for feature inputs -->
                <div id="featuresContainer" class="space-y-2">
                    <input type="text" name="features[]" placeholder="Feature 1"
                        class="border-2 outline-none px-2 py-1 rounded-lg w-full" id="Description0">
                </div>

                <!-- Button to add more features -->
                <div class="w-full flex flex-row justify-center gap-2">
                    <button type="button" id="addFeatureBtn"
                        class="mt-2 bg-orange-400 text-white px-3 py-1 rounded-full hover:bg-orange-600">
                     Add Feature
                </button>
                <button type="button" id="removeFeatureBtn"
                        class="mt-2 bg-orange-400 text-white px-3 py-1 rounded-full hover:bg-orange-600">
                     remove Feature
                </button>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-between w-full gap-4 pt-2 ">
               <div class="flex flex-col">
                 <label for="" class="pb-2">Discount value</label>
                <div class="flex flex-col gap-4 w-full h-max">
                    <div class="flex flex-row justify-center">
                        <p id="discountValue" class="text-center">0</p>
                        <span>%</span>
                    </div>
                    <div class="flex flex-row  justify-between px-auto ">
                        <i id="discountplus" class="ri-add-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                        <i id="discountminus" class="ri-subtract-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                    </div>
                </div>
               </div>
                <div class="flex flex-col">
                 <label for="" class="pb-2">Duration value</label>
                <div class="flex flex-col gap-2 w-full">
                    <input id="durationValue"  type="number" placeholder="" readonly value="1" class="  h-max text-center border-2 outline-none px-2 py-1 rounded-lg">
                    <div class="flex flex-row  justify-between px-auto ">
                        <i id="plus" class="ri-add-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                        <i id="minus" class="ri-subtract-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                    </div>
                </div>
               </div>
            </div>
            <div class="flex flex-col w-full gap-2">
                <label for="">Price</label>
                <input id="amount" type="number" placeholder="Amount" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            
        </div>
        <div class="flex flex-col py-2">
            <button id="addplanBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Add & confirm</button>
        </div>
    </div>
</div>
<!--edit plan pupup form-->
<div id="editPlan" class="fixed z-40 inset-0 bg-black/50 flex hidden  overflow-y-auto   justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="editPlancross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Edit plan</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Plan name</label>
                <input id="editplaneName" type="text" placeholder="Plan name" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            <div class="flex flex-col w-full gap-4 ">
                <label for="">Duration</label>
                <select name="" id="editDurationOption" class="border-2 text-md">
                    <option value="default" default>--select--</option>
                    <option value="day">Day</option>
                    <option value="week">Week</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <div class="flex flex-col w-full gap-2">
                <label for="">Plan Features</label>

                <!-- Container for feature inputs -->
                <div id="editfeaturesContainer" class="space-y-2">
                </div>

                <!-- Button to add more features -->
                <div class="w-full flex flex-row justify-center gap-2">
                    <button type="button" id="editaddFeatureBtn"
                        class="mt-2 bg-orange-400 text-white px-3 py-1 rounded-full hover:bg-orange-600">
                     Add Feature
                </button>
                <button type="button" id="editremoveFeatureBtn"
                        class="mt-2 bg-orange-400 text-white px-3 py-1 rounded-full hover:bg-orange-600">
                     remove Feature
                </button>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row justify-between w-full gap-4 pt-2 ">
               <div class="flex flex-col">
                 <label for="" class="pb-2">Discount value</label>
                <div class="flex flex-col gap-4 w-full h-max">
                    <div class="flex flex-row justify-center">
                        <p id="editdiscountValue" class="text-center">0</p>
                        <span>%</span>
                    </div>
                    <div class="flex flex-row  justify-between px-auto ">
                        <i id="editdiscountplus" class="ri-add-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                        <i id="editdiscountminus" class="ri-subtract-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                    </div>
                </div>
               </div>
                <div class="flex flex-col">
                 <label for="" class="pb-2">Duration value</label>
                <div class="flex flex-col gap-2 w-full">
                    <input id="editdurationValue"  type="number" placeholder="" readonly value="1" class="  h-max text-center border-2 outline-none px-2 py-1 rounded-lg">
                    <div class="flex flex-row  justify-between px-auto ">
                        <i id="editplus" class="ri-add-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                        <i id="editminus" class="ri-subtract-line bg-orange-400 text-white border-2 w-max text-lg hover:bg-orange-600 p-2 cursor-pointer"></i>
                    </div>
                </div>
               </div>
            </div>
            <div class="flex flex-col w-full gap-2">
                <label for="">Price</label>
                <input id="editamount" type="number" placeholder="Amount" class="border-2 outline-none px-2 py-1 rounded-lg">
            </div>
            
        </div>
        <div class="flex flex-col py-2">
            <button id="editplanBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Edit & confirm</button>
        </div>
    </div>
</div>
<!--delete plan pupup form-->
<div id="deleteplanpopup" class="fixed z-40 inset-0 bg-black/50 hidden  flex justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="deletepopupcross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Delete plan</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4 text-center text-red-500 font-bold">
                <p>Are sure you want to remove the plan:</p>
                
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">plan name</label>
                <input id="planName" type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">plan Duration</label>
                <input id="planDuration" type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">plan tariff</label>
                <input id="planTarif" type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            
        </div>
        <div class="flex flex-col py-2">
            <button id="deleteplanBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Delete plan</button>
        </div>
    </div>
</div>

</body>
<script src="main.js"></script>
<script src="tariffs.js"></script>
</html>