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
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="#">Members</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="subscriptionTarifs.php">Subscriptions/Plans</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="payments.php">Payments</a></li>
        <li class="text-orange-400 text-lg hover:bg-gray-200 hover:text-orange-600 px-3 py-2 cursor-pointer"><a href="blacklist.php">Blacklist</a></li>
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
            <h2 class=" text-gray-600 font-bold w-full text-center">Trainer List</h2>
            <i id="addTrainer" class="ri-add-fill text-orange-400 text-2xl font-bold transform transition hover:scale-105 hover:-translate-y-1 cursor-pointer hover:text-orange-600"></i>
        </div>
        <div class="w-full overflow-auto   rounded-lg shadow-xl ">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Trainer No.</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Fist Name</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Last Name</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Email</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Tel</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Level</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Status</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Joining date</th>
                        <th class="bg-gray-100 p-2 text-gray-500 whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="9" class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">Fetching data..</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--blacklist pupup form-->
<div id="blacklistMemberpopup" class="fixed z-40 inset-0 bg-black/50 hidden  flex justify-center">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit mt-20 px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="blacklisttrainercross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Add to blacklist</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4 text-center text-red-500 font-bold">
                <p>Are sure you want to blacklist the memeber:</p>
                
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Member number</label>
                <input id="blacklistMemberId" type="number" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input id="blacklistmemberEmail" type="email" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Tel</label>
                <input id="blacklistMemberTel" type="number" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            
        </div>
        <div class="flex flex-col py-2">
            <button id="blacklistmemberBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Add to blackList</button>
        </div>
    </div>
</div>
<!--edit member detils pupup form-->
<div id="edittrainerdata" class="fixed z-40 inset-0 bg-black/50   hidden flex justify-center items-start h-screen overflow-y-auto pt-2">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit  px-4 py-2">
        <div class="w-full flex justify-end">
            <i id="editTrainerdataCross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-2xl">Edit Details</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4">
                <label for="">Member number</label>
                <input id="edittrainerId" type="number" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" readonly>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">First name</label>
                <input id="edittrainerFname" type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg " >
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Last Name</label>
                <input id="edittrainerLname" type="text" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" >
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input id="edittrainerEmail" type="email" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" >
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Tel</label>
                <input id="editrainerTel" type="number" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" >
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button id="edittrainerdataBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Save Changes</button>
        </div>
    </div>
</div>
<!--add new member pupup form-->
<div id="addNewtrainer" class="fixed z-40 inset-0 bg-black/50 flex hidden  overflow-y-auto mb-10 justify-center items-start h-screen">
    <div class="bg-white rounded-xl w-full max-w-md mx-2 md:max-w-lg h-fit  px-4 py-2 mt-2 mb-6 ">
        <div class="w-full flex justify-end">
            <i id="edittrainerdataCross" class="ri-close-large-line cursor-pointer inline-block text-xl text-orange-400 transform transition duration-200 hover:scale-125 hover:text-orange-600"></i>
        </div>
        <h2 class="mb-2 font-semibold text-center text-lg">Add New Trainer</h2>
        <div class="space-y-2">
            <div class="flex flex-col w-full gap-4 ">
                <label for="">Level</label>
                <select name="" id="trainersOption" class="border-2 text-md">
                    <option value="default" default>--select--</option>
                    <option value="Gym Instructor">Gym Instructor</option>
                    <option value="Personal Trainer">Personal Trainer</option>
                    <option value="Specialist Trainer">Specialist Trainer</option>
                    <option value="Advanced/Clinical Trainer">Advanced/Clinical Trainer</option>
                </select>
                <p id="trainerOptionError" class=" text-red-500 font-semibold"></p>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">First name</label>
                <input id="trainerFname" type="text" placeholder="Your first name" class="border-2 outline-none px-2 py-1 rounded-lg " >
                <p id="trainerFnameError" class=" text-red-500 font-semibold"></p>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Last Name</label>
                <input id="trainerLname" type="text" placeholder="Your last name" class="border-2 outline-none px-2 py-1 rounded-lg" >
                <p id="trainerLnameError" class=" text-red-500 font-semibold"></p>
            </div>
            
            <div class="flex flex-col w-full gap-4">
                <label for="">Email</label>
                <input id="trainerEmail" type="email" placeholder="your name" class="border-2 outline-none px-2 py-1 rounded-lg" >
                <p id="trainerEmailError" class=" text-red-500 font-semibold"></p>
            </div>
            <div class="flex flex-col w-full gap-4">
                <label for="">Tel</label>
                <input id="trainerTel" type="number" placeholder="Your tel" class="border-2 outline-none px-2 py-1 rounded-lg" >
                <p id="trainerTelError" class=" text-red-500 font-semibold"></p>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <button id="addNewtrainerBtn" class="bg-orange-400 px-2 py-2 rounded-full text-white hover:bg-orange-600">Add New Trainer</button>
        </div>
    </div>
</div>
</body>
<script src="main.js"></script>
<script src="trainers.js"></script>
</html>