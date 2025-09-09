function sanitize(input) {
    if (typeof input !== "string") return input;

    const map = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#39;",
        "`": "&#96;"
    };

    return input
        .trim()
        .replace(/[&<>"'`]/g, match => map[match])
        .replace(/\r?\n|\r/g, " "); // normalize newlines
}
function isValidEmail(value) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
}
function validateAndFormatKenyanPhone(phone) {
    // Remove spaces, hyphens, parentheses
    const cleaned = phone.replace(/[\s-()]/g, "");

    // Check if it starts with 07 and has exactly 10 digits
    const regex = /^07\d{8}$/;

    if (regex.test(cleaned)) {
        // Convert to +254 format
        return "+254" + cleaned.substring(1);
    } else {
        return null; // invalid number
    }
}
let originalData='';
async function trainersData(tbody,adminCsrfToken,edittrainerdata,edittrainerId,edittrainerFname,
                edittrainerLname,edittrainerEmail,edittrainerTel,blacklisttrainerpopup,
                blacklisttrainerId,blacklisttrainerEmail,blacklisttrainerTel) {
    const postData ={
        trainersData:true,
        adminCsrfToken:sanitize(adminCsrfToken.value)
    };
    try{
        const response =await fetch('fetch.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(postData)
        });
        const text = await response.text();
       console.log(text);
        try{
            const result = JSON.parse(text);
            if(result.success){
                console.log(result.trainers.length);
                if(result.trainers.length>1){
                    const mapedData = result.trainers.map((items,index)=>{
                        return `
                        <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${index +1}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.unid}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.first_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.last_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.email}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.tel}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.level}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.status}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.joining_date}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center flex flex-row gap-2">
                                <button id="edittrainer" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${items.unid}">Edit</button>
                                <button id="blacklistTrainer" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${items.unid}">Blacklist</button>
                            </td>
                        </tr>
                        `;
                }).join("");
                tbody.innerHTML=mapedData;
                }else if(result.trainers.length==1){
                    tbody.innerHTML=`
                      <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">1</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].unid}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].first_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].last_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].email}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].tel}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].level}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].status}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.trainers[0].joining_date}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center flex flex-row gap-2">
                                <button id="edittrainer" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result[0].unid}">Edit</button>
                                <button id="blacklistTrainer" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.unid}">Blacklist</button>
                            </td>
                        </tr>
                    `;

                }else if(result.trainers.length==0){
                     tbody.innerHTML=`
                      <tr>
                            <td colspan="9" class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap text-center">No trainers </td>
                        </tr>
                    `;
                    
                }
                //edit blacklist
                
                const edittrainer = document.querySelectorAll("#edittrainer");
                const blacklistTrainer = document.querySelectorAll("#blacklistTrainer");
                blacklistTrainer.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                        console.log("blacklist")
                        const unid = e.currentTarget.value;
                        const data = result.members.find(plan =>plan.unid === unid);
                        blacklistMemberpopup.classList.remove("hidden");
                        blacklistMemberId.value=data.unid;
                        blacklistmemberEmail.value=data.email;
                        blacklistMemberTel.value=data.tel;
                    });
                });
                edittrainer.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                       edittrainerdata.classList.remove("hidden");
                        const unid = e.currentTarget.value;
                        const data = result.trainers.find(plan =>plan.unid === unid);
                        console.log(data)
                        edittrainerId.value=data.unid;
                        edittrainerFname.value=data.first_name;
                        edittrainerLname.value=data.last_name;
                        edittrainerEmail.value=data.email;
                        edittrainerTel.value=data.tel;
                        //store original data
                         originalData = {
                            edittrainerId:data.unid,
                            edittrainerFname:data.first_name,
                            edittrainerLname:data.last_name,
                            edittrainerEmail:data.email,
                            edittrainerTel:data.tel
                        };
                    });
                });

            }
        }catch(jsonErr){
            console.log("error from server:" + jsonErr);
        }
    }catch(error){
        console.log("error making activemember request:" + error);
    }
}
addEventListener("DOMContentLoaded",()=>{
    const addTrainer = document.querySelector("#addTrainer");
    const addNewTrainer = document.querySelector("#addNewtrainer");
    const editTrainerdataCross = document.querySelector("#editTrainerdataCross");
    const addNewtrainerBtn = document.querySelector("#addNewtrainerBtn");
    const alertMessage = document.querySelector("#alertMessage");
    const p = document.querySelector("p");
    const tbody = document.querySelector("tbody");
    const trainerFname = document.querySelector("#trainerFname");
    const trainerLname = document.querySelector("#trainerLname");
    const trainerEmail = document.querySelector("#trainerEmail");
    const trainerTel = document.querySelector("#trainerTel");
    const trainersOption = document.querySelector("#trainersOption");
    const trainerEmailError = document.querySelector("#trainerEmailError");
    const trainerOptionError = document.querySelector("#trainerOptionError");
    const trainerFnameError = document.querySelector("#trainerFnameError");
    const trainerLnameError = document.querySelector("#trainerLnameError");
    const trainerTelError = document.querySelector("#trainerTelError");
    const adminCsrfToken = document.querySelector("#adminCsrfToken");
    const edittrainerdata = document.querySelector("#edittrainerdata");
    const edittrainerId = document.querySelector("#edittrainerId");
    const edittrainerFname = document.querySelector("#edittrainerFname");
    const edittrainerLname = document.querySelector("#edittrainerLname");
    const edittrainerEmail = document.querySelector("#edittrainerEmail");
    const edittrainerTel = document.querySelector("#editrainerTel");
    const edittrainerdataBtn = document.querySelector("#edittrainerdataBtn");
    const edittrainerdataCross = document.querySelector("#editTrainerdataCross");
    const blacklisttrainerpopup = document.querySelector("#blacklisttrainerpopup");
    const blacklisttrainerId = document.querySelector("#blacklisttrainerId");
    const blacklisttrainerEmail = document.querySelector("#blacklisttrainerEmail");
    const blacklisttrainerTel = document.querySelector("#blacklisttrainerTel");
    const blacklisttrainercross = document.querySelector("#blacklisttrainercross");
    const blacklisttrainerBtn = document.querySelector("#blacklisttrainerBtn");
    let trainerregisterTelstate=false;
    let trainerEmailstate=false;
    let trainerFnamestate=false;
    let trainerLnamestate=false;
    let traineroptionstate=false;
    trainersData(tbody,adminCsrfToken,edittrainerdata,edittrainerId,edittrainerFname,
                edittrainerLname,edittrainerEmail,edittrainerTel,blacklisttrainerpopup,
                blacklisttrainerId,blacklisttrainerEmail,blacklisttrainerTel);
    addTrainer.addEventListener("click",()=>{
        addNewTrainer.classList.toggle("hidden");
    });
    edittrainerdataCross.addEventListener("click",()=>{
        edittrainerdata.classList.toggle("hidden");
    });
    blacklisttrainercross.addEventListener("click",()=>{
        blacklistMemberpopup.classList.toggle("hidden");
    });
    blacklistmemberBtn.addEventListener("click",()=>{
        console.log("addblacklist")
        //updated data 
            const updatedData = {
                blacklistMemberId:sanitize(blacklistMemberId.value),
                adminCsrfToken:sanitize(adminCsrfToken.value),
                blacklistmemberStatus:true
            };
            
                async function blacklistmemberFunction() {
                const response = await fetch('fetch.php',{
                    method:"POST",
                    headers:{"Content-Type":"application/json"},
                    body:JSON.stringify(updatedData)
                });
                const text = await response.text();
                console.log(text);
                try{
                    const result = JSON.parse(text);
                    if(result.success){
                        // success
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex","animate-slide-down");
                        setTimeout(() => {
                            alertMessage.classList.remove("animate-slide-down");
                            alertMessage.classList.add("animate-slide-up");
                            editMemberdataBtn.disabled=true;
                        }, 2000);
                        //close modal and clear content
                        setTimeout(()=>{
                            alertMessage.classList.add("hidden");
                            alertMessage.classList.remove("flex");
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            editMemberdataBtn.disabled=false;
                            blacklistMemberpopup.classList.add("hidden");
                            blacklistMemberId.value="";
                            blacklistmemberEmail.value="";
                            blacklistMemberTel.value="";
                            membersData(tbody,adminCsrfToken,editMemberdata,editMemberId,
                                    editmemberFname,editmemberLname,editmemberEmail,editMemberTel,
                                    blacklistMemberpopup,blacklistMemberId,blacklistmemberEmail,
                                    blacklistMemberTel);
                        },2400);
                        
                    }else{
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex");
                        editMemberdataBtn.disabled=false;
                        alertMessage.classList.add("animate-slide-down");
                        setTimeout(() => {
                            alertMessage.classList.remove("animate-slide-down");
                            alertMessage.classList.add("animate-slide-up");
                        }, 2000);
                        setTimeout(() => {
                            alertMessage.classList.add("hidden","animate-slide-down");
                            alertMessage.classList.remove("flex","animate-slide-up");
                        }, 2400);
                    }
                }
                catch(jsonErr){
                    console.log("response error:" + jsonErr);
                }
            }
            blacklistmemberFunction();
            
    });


        edittrainerdataBtn.addEventListener("click",()=>{
        //updated data 
            const updatedData = {
                edittrainerId:sanitize(edittrainerId.value),
                edittrainerFname:sanitize(edittrainerFname.value),
                edittrainerLname:sanitize(edittrainerLname.value),
                edittrainerEmail:sanitize(edittrainerEmail.value),
                edittrainerTel:sanitize(edittrainerTel.value)
            };
            //check if data has changed
             const hasChanges = Object.keys(originalData).some(
                key => originalData[key] !== updatedData[key]
            );
            if(hasChanges){
                async function addPlanFunction() {
                    updatedData.adminCsrfToken = sanitize(adminCsrfToken.value);
                    updatedData.edittrainerDataStatus = true;
                const response = await fetch('fetch.php',{
                    method:"POST",
                    headers:{"Content-Type":"application/json"},
                    body:JSON.stringify(updatedData)
                });
                const text = await response.text();
                try{
                    const result = JSON.parse(text);
                    if(result.success){
                        // success
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex","animate-slide-down");
                        setTimeout(() => {
                            alertMessage.classList.remove("animate-slide-down");
                            alertMessage.classList.add("animate-slide-up");
                            edittrainerdataBtn.disabled=true;
                        }, 2000);
                        //close modal and clear content
                        setTimeout(()=>{
                            alertMessage.classList.add("hidden");
                            alertMessage.classList.remove("flex");
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            edittrainerdataBtn.disabled=false;
                            edittrainerdata.classList.add("hidden");
                            edittrainerId.value="";
                            edittrainerFname.value="";
                            edittrainerLname.value="";
                            edittrainerEmail.value="";
                            edittrainerTel.value="";
                           trainersDataData(tbody,adminCsrfToken,edittrainerdata,edittrainerId,edittrainerFname,
                                        edittrainerLname,edittrainerEmail,edittrainerTel,blacklisttrainerpopup,
                                        blacklisttrainerId,blacklisttrainerEmail,blacklisttrainerTel);
                        },2400);
                        
                    }else{
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex");
                        edittrainerdataBtn.disabled=false;
                        alertMessage.classList.add("animate-slide-down");
                        setTimeout(() => {
                            alertMessage.classList.remove("animate-slide-down");
                            alertMessage.classList.add("animate-slide-up");
                        }, 2000);
                        setTimeout(() => {
                            alertMessage.classList.add("hidden","animate-slide-down");
                            alertMessage.classList.remove("flex","animate-slide-up");
                        }, 2400);
                    }
                }
                catch(jsonErr){
                    console.log("response error:" + jsonErr);
                }
            }
            addPlanFunction();
            }else{
                p.textContent = "No changes found";
                alertMessage.classList.remove("hidden");
                alertMessage.classList.add("flex");
                addplanBtn.disabled=false;
                alertMessage.classList.add("animate-slide-down");
                setTimeout(() => {
                    alertMessage.classList.remove("animate-slide-down");
                    alertMessage.classList.add("animate-slide-up");
                }, 2000);
                setTimeout(() => {
                    alertMessage.classList.add("hidden","animate-slide-down");
                    alertMessage.classList.remove("flex","animate-slide-up");
                    // loginPopup.classList.add("hidden");
                    // loginPopup.classList.remove("flex");
                }, 2400);
            }
    });
    trainerLname.addEventListener("blur",()=>{
        if(trainerLname.value==""){
            trainerLnamestate=false;
            trainerLnameError.innerHTML="invalid last name";
        }else{
            trainerLnameError.innerHTML="";
            trainerLnamestate=true;
        }
    });
    trainerFname.addEventListener("blur",()=>{
        if(trainerFname.value==""){
            trainerFnamestate=false;
            trainerFnameError.innerHTML="invalid first name";
        }else{
            trainerFnameError.innerHTML="";
            trainerFnamestate=true;
        }
    });
    trainersOption.addEventListener("change",()=>{
        if(trainersOption.value=="default"){
            traineroptionstate=false;
            trainerOptionError.innerHTML="invalid level";
        }else{
            trainerOptionError.innerHTML="";
            traineroptionstate=true;
            console.log(trainersOption.value)
        }
    });
    trainerEmail.addEventListener("blur",()=>{
        if(!isValidEmail(trainerEmail.value)){
            trainerEmailstate=false;
            trainerEmailError.innerHTML="invalid email";
        }else{
            trainerEmailError.innerHTML="";
            trainerEmailstate=true;
        }
    });
     trainerTel.addEventListener("blur",()=>{
        if(!validateAndFormatKenyanPhone(trainerTel.value)){
            trainerregisterTelstate=false;
            trainerTelError.innerHTML="invalid tel";
        }else{
            trainerregisterTelstate=true;
            trainerTelError.innerHTML="";
        }
    });
    addNewtrainerBtn.addEventListener("click",()=>{
        const adminCsrf = adminCsrfToken.value;
        if(trainerregisterTelstate && trainerEmailstate && traineroptionstate &&trainerFnamestate &&trainerLnamestate){
            const postData= {
                trainerregistrationStatus:true,
                trainerEmail:sanitize(trainerEmail.value),
                trainerTel:sanitize(trainerTel.value),
                trainerLname:sanitize(trainerLname.value),
                trainerFname:sanitize(trainerFname.value),
                level:sanitize(trainersOption.value),
                adminCsrfToken:sanitize(adminCsrf)
            };
            async function registerNewMembersFunction() {
                const response = await fetch('fetch.php',{
                    method:"POST",
                    headers:{"Content-Type":"application/json"},
                    body:JSON.stringify(postData)
                });
                const text = await response.text();
                console.log(text);
                try{
                    const result = JSON.parse(text);
                    if(result.success){
                        // success
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex","animate-slide-down");
                        setTimeout(() => {
                            alertMessage.classList.remove("animate-slide-down");
                            alertMessage.classList.add("animate-slide-up");
                            addNewtrainerBtn.disabled=true;
                        }, 2000);
                        //close modal and clear content
                        setTimeout(()=>{
                            alertMessage.classList.add("hidden");
                            alertMessage.classList.remove("flex");
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            addNewtrainerBtn.disabled=false;
                            trainerEmail.value="";
                            trainerTel.value ="";
                            trainerLname.value="";
                            trainerFname.value="";
                            trainersOption.value="--select--";
                            addNewTrainer.classList.add("hidden");
                           trainersData(tbody,adminCsrfToken,edittrainerdata,edittrainerId,edittrainerFname,
                                    edittrainerLname,edittrainerEmail,edittrainerTel,blacklisttrainerpopup,
                                    blacklisttrainerId,blacklisttrainerEmail,blacklisttrainerTel);
                        },2400);
                        
                    }else{
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex");
                        addNewtrainerBtn.disabled=false;
                        alertMessage.classList.add("animate-slide-down");
                        setTimeout(() => {
                            alertMessage.classList.remove("animate-slide-down");
                            alertMessage.classList.add("animate-slide-up");
                        }, 2000);
                        setTimeout(() => {
                            alertMessage.classList.add("hidden","animate-slide-down");
                            alertMessage.classList.remove("flex","animate-slide-up");
                        }, 2400);
                    }
                }
                catch(jsonErr){
                    console.log("response error:" + jsonErr);
                }
            }
            registerNewMembersFunction();
        }else{
            p.textContent = "check form details";
            alertMessage.classList.remove("hidden");
            alertMessage.classList.add("flex");
            addNewMemberBtn.disabled=false;
            alertMessage.classList.add("animate-slide-down");
            setTimeout(() => {
                alertMessage.classList.remove("animate-slide-down");
                alertMessage.classList.add("animate-slide-up");
            }, 2000);
            setTimeout(() => {
                alertMessage.classList.add("hidden","animate-slide-down");
                alertMessage.classList.remove("flex","animate-slide-up");
            }, 2400);
        }
    });
});