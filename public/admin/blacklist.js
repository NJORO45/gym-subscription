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
let originalData='';
async function membersData(tbody,adminCsrfToken,whitelistMemberpopup,
                whitelistMemberId,whiteistMemberTel,whitelistmemberEmail) {
    const postData ={
        blacklistmembersData:true,
        adminCsrfToken:sanitize(adminCsrfToken.value)
    };
    try{
        const response =await fetch('fetch.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(postData)
        });
        const text = await response.text();
       //console.log(text);
        try{
            const result = JSON.parse(text);
            if(result.success){
                //console.log(result.members.length)
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
                }else if(result.members.length==1){
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
                                <button id="whitelistMember" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.members[0].unid}">Whitelist</button>
                            </td>
                        </tr>
                    `;

                }else if(result.members.length==0){
                     tbody.innerHTML=`
                      <tr>
                            <td colspan="9" class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap text-center">No blacklist </td>
                        </tr>
                    `;
                    
                }
                //edit whitelist
                const whitelistMember = document.querySelectorAll("#whitelistMember");
                whitelistMember.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                        console.log("blacklist")
                        const unid = e.currentTarget.value;
                        const data = result.members.find(plan =>plan.unid === unid);
                        whitelistMemberpopup.classList.remove("hidden");
                        whitelistMemberId.value=data.unid;
                        whitelistmemberEmail.value=data.email;
                        whiteistMemberTel.value=data.tel;
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
    const alertMessage = document.querySelector("#alertMessage");
    const p = document.querySelector("p");
    const tbody = document.querySelector("tbody");
    const adminCsrfToken = document.querySelector("#adminCsrfToken");
    const whitelistMemberpopup = document.querySelector("#whitelistMemberpopup");
    const whitelistMemberId = document.querySelector("#whitelistMemberId");
    const whitelistmemberEmail = document.querySelector("#whitelistmemberEmail");
    const whiteistMemberTel = document.querySelector("#whiteistMemberTel");
    const whitelistMembercross = document.querySelector("#whitelistMembercross");
    const whitelistmemberBtn = document.querySelector("#whitelistmemberBtn");
    let registerTelstate=false;
    let registerEmailstate=false;
    membersData(tbody,adminCsrfToken,whitelistMemberpopup,
                whitelistMemberId,whiteistMemberTel,whitelistmemberEmail);
    whitelistMembercross.addEventListener("click",()=>{
        whitelistMemberpopup.classList.toggle("hidden");
    });
    whitelistmemberBtn.addEventListener("click",()=>{
        console.log("addblacklist")
        //updated data 
            const updatedData = {
                whitelistMemberId:sanitize(whitelistMemberId.value),
                adminCsrfToken:sanitize(adminCsrfToken.value),
                whitelistmemberStatus:true
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
                            whitelistmemberBtn.disabled=true;
                        }, 2000);
                        //close modal and clear content
                        setTimeout(()=>{
                            alertMessage.classList.add("hidden");
                            alertMessage.classList.remove("flex");
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            whitelistmemberBtn.disabled=false;
                            whitelistMemberpopup.classList.add("hidden");
                            whitelistMemberId.value="";
                            whitelistmemberEmail.value="";
                            whiteistMemberTel.value="";
                            membersData(tbody,adminCsrfToken,whitelistMemberpopup,
                                          whitelistMemberId,whiteistMemberTel,whitelistmemberEmail);
                        },2400);
                        
                    }else{
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex");
                        whitelistmemberBtn.disabled=false;
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


});