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
async function membersData(tbody,adminCsrfToken,editMemberdata,editMemberId,
                editmemberFname,editmemberLname,editmemberEmail,editMemberTel,
                blacklistMemberpopup,blacklistMemberId,blacklistmemberEmail,
                blacklistMemberTel) {
    const postData ={
        membersData:true,
        adminCsrfToken:sanitize(adminCsrfToken.value)
    };
    try{
        const response =await fetch('fetch.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(postData)
        });
        const text = await response.text();
       // console.log(text);
        try{
            const result = JSON.parse(text);
            if(result.success){
                if(result.members.length>1){
                    const mapedData = result.members.map((items,index)=>{
                        return `
                        <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${index +1}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.unid}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.first_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.last_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.email}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.tel}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.accountStatus}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.created_at}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center flex flex-row gap-2">
                                <button id="editMember" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.members.unid}">Edit</button>
                                <button id="blacklistMember" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.members.unid}">Blacklist</button>
                            </td>
                        </tr>
                        `;
                }).join("");
                tbody.innerHTML=mapedData;
                }else{
                    tbody.innerHTML=`
                      <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">1</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.members[0].unid}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.members[0].first_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.members[0].last_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.members[0].email}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.members[0].tel}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.members[0].accountStatus}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.members[0].created_at}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center flex flex-row gap-2">
                                <button id="editMember" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.members[0].unid}">Edit</button>
                                <button id="blacklistMember" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.members[0].unid}">Blacklist</button>
                            </td>
                        </tr>
                    `;
                }
                //edit blacklist
                
                const editBtn = document.querySelectorAll("#editMember");
                const blacklistMember = document.querySelectorAll("#blacklistMember");
                blacklistMember.forEach(btn=>{
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
                editBtn.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                       editMemberdata.classList.remove("hidden");
                        console.log("edit")
                        editMemberId,editmemberFname,editmemberLname,editmemberEmail,editMemberTel
                        const unid = e.currentTarget.value;
                        const data = result.members.find(plan =>plan.unid === unid);
                        editMemberId.value=data.unid;
                        editmemberFname.value=data.first_name;
                        editmemberLname.value=data.last_name;
                        editmemberEmail.value=data.email;
                        editMemberTel.value=data.tel;
                        //store original data
                         originalData = {
                            editMemberId:data.unid,
                            editmemberFname:data.first_name,
                            editmemberLname:data.last_name,
                            editmemberEmail:data.email,
                            editMemberTel:data.tel
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
    const addMember = document.querySelector("#addMember");
    const addNewMember = document.querySelector("#addNewMember");
    const addNewMembercross = document.querySelector("#addNewMembercross");
    const addNewMemberBtn = document.querySelector("#addNewMemberBtn");
    const alertMessage = document.querySelector("#alertMessage");
    const registerTel = document.querySelector("#registerTel");
    const registerEmail = document.querySelector("#registerEmail");
    const registerLname = document.querySelector("#registerLname");
    const registerFname = document.querySelector("#registerFname");
    const p = document.querySelector("p");
    const tbody = document.querySelector("tbody");
    const registerEmailError = document.querySelector("#registerEmailError");
    const registerTelError = document.querySelector("#registerTelError");
    const adminCsrfToken = document.querySelector("#adminCsrfToken");
    const editMemberdata = document.querySelector("#editMemberdata");
    const editMemberId = document.querySelector("#editMemberId");
    const editmemberFname = document.querySelector("#editmemberFname");
    const editmemberLname = document.querySelector("#editmemberLname");
    const editmemberEmail = document.querySelector("#editmemberEmail");
    const editMemberTel = document.querySelector("#editMemberTel");
    const editMemberdataBtn = document.querySelector("#editMemberdataBtn");
    const editMemberdataCross = document.querySelector("#editMemberdataCross");
    const blacklistMemberpopup = document.querySelector("#blacklistMemberpopup");
    const blacklistMemberId = document.querySelector("#blacklistMemberId");
    const blacklistmemberEmail = document.querySelector("#blacklistmemberEmail");
    const blacklistMemberTel = document.querySelector("#blacklistMemberTel");
    const blacklistMembercross = document.querySelector("#blacklistMembercross");
    const blacklistmemberBtn = document.querySelector("#blacklistmemberBtn");
    let registerTelstate=false;
    let registerEmailstate=false;
    membersData(tbody,adminCsrfToken,editMemberdata,editMemberId,editmemberFname,
                editmemberLname,editmemberEmail,editMemberTel,blacklistMemberpopup,
                blacklistMemberId,blacklistmemberEmail,blacklistMemberTel);
    addMember.addEventListener("click",()=>{
        addNewMember.classList.toggle("hidden")
    });
    addNewMembercross.addEventListener("click",()=>{
        addNewMember.classList.toggle("hidden");
    });
    blacklistMembercross.addEventListener("click",()=>{
        blacklistMemberpopup.classList.toggle("hidden");
    });
    editMemberdataCross.addEventListener("click",()=>{
        editMemberdata.classList.toggle("hidden");
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


        editMemberdataBtn.addEventListener("click",()=>{
        //updated data 
            const updatedData = {
                editMemberId:sanitize(editMemberId.value),
                editmemberFname:sanitize(editmemberFname.value),
                editmemberLname:sanitize(editmemberLname.value),
                editmemberEmail:sanitize(editmemberEmail.value),
                editMemberTel:sanitize(editMemberTel.value)
            };
            //check if data has changed
             const hasChanges = Object.keys(originalData).some(
                key => originalData[key] !== updatedData[key]
            );

            console.log(originalData,updatedData);
            if(hasChanges){
                async function addPlanFunction() {
                    updatedData.adminCsrfToken = sanitize(adminCsrfToken.value);
                    updatedData.editmemberDataStatus = true;
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
                            editMemberdataBtn.disabled=true;
                        }, 2000);
                        //close modal and clear content
                        setTimeout(()=>{
                            alertMessage.classList.add("hidden");
                            alertMessage.classList.remove("flex");
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            editMemberdataBtn.disabled=false;
                            editMemberdata.classList.add("hidden");
                            editMemberId.value="";
                            editmemberFname.value="";
                            editmemberLname.value="";
                            editmemberEmail.value="";
                            editMemberTel.value="";
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

    registerEmail.addEventListener("blur",()=>{
        if(!isValidEmail(registerEmail.value)){
            registerEmailstate=false;
            registerEmailError.innerHTML="invalid email";
        }else{
            registerEmailError.innerHTML="";
            registerEmailstate=true;
        }
    });
     registerTel.addEventListener("blur",()=>{
        if(!validateAndFormatKenyanPhone(registerTel.value)){
            registerTelstate=false;
            registerTelError.innerHTML="invalid tel";
        }else{
            registerTelstate=true;
            registerTelError.innerHTML="";
        }
    });
    addNewMemberBtn.addEventListener("click",()=>{
        const adminCsrf = adminCsrfToken.value;
        if(registerTelstate && registerEmailstate){
            const postData= {
                registrationStatus:true,
                registerEmail:sanitize(registerEmail.value),
                registerTel:sanitize(registerTel.value),
                registerLname:sanitize(registerLname.value),
                registerFname:sanitize(registerFname.value),
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
                            addNewMemberBtn.disabled=true;
                        }, 2000);
                        //close modal and clear content
                        setTimeout(()=>{
                            alertMessage.classList.add("hidden");
                            alertMessage.classList.remove("flex");
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            addNewMemberBtn.disabled=false;
                            registerEmail.value="";
                            registerTel.value="";
                            registerLname.value="";
                            registerFname.value="";
                            addNewMember.classList.add("hidden");
                           membersData(tbody,adminCsrfToken,editMemberdata,editMemberId,
                                        editmemberFname,editmemberLname,editmemberEmail,editMemberTel,
                                        blacklistMemberpopup,blacklistMemberId,blacklistmemberEmail,
                                        blacklistMemberTel);
                        },2400);
                        
                    }else{
                        p.textContent = result.message;
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
                }
                catch(jsonErr){
                    console.log("response error:" + jsonErr);
                }
            }
            registerNewMembersFunction();
        }else{
            p.textContent = "check email/ tel";
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