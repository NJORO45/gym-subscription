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
async function tariffData(tbody,adminCsrfToken,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount) {
    const postData ={
        tariffData:true,
        adminCsrfToken:sanitize(adminCsrfToken.value)
    };
    try{
        const response =await fetch('fetch.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(postData)
        });
        const text = await response.text();
        
        try{
            const result = JSON.parse(text);
            if(result.success){
                if(result.tariffs.length>1){
                    const mapedData = result.tariffs.map((items,index)=>{
                        return `
                        <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${index +1}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.duration_value} ${items.duration_type}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.tariff}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.discount}%</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center">
                               <button id="editBtn" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${items.unid}">Edit</button
                            </td>
                        </tr>
                        `;
                }).join("");
                tbody.innerHTML=mapedData;
                }else{
                    tbody.innerHTML=`
                      <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">1</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].duration_value} ${result.tariffs[0].duration_type}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].tariff}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].discount}%</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center">
                               <button id="editBtn" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.tariffs[0].unid}">Edit</button
                            </td>
                        </tr>
                    `;
                }
                
                const editBtn = document.querySelectorAll("#editBtn");
                editBtn.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                        editPlan.classList.remove("hidden");
                        const unid = e.currentTarget.value;
                        const data = result.tariffs.find(plan =>plan.unid === unid);
                        editplaneName.value=data.name;
                        editDurationOption.value=data.duration_type;
                        editdiscountValue.value=data.discount;
                        editdurationValue.value=data.duration_value;
                        editamount.value=data.tariff;
                        editplanBtn.value=data.unid;
                        //store original data
                         originalData = {
                            unid:data.unid,
                            editplaneName:data.name,
                            editDurationOption:data.duration_type,
                            editdiscountValue:data.discount,
                            editdurationValue:String(data.duration_value),
                            editamount:data.tariff
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
    const editPlancross = document.querySelector("#editPlancross");
    const editPlan = document.querySelector("#editPlan");
    const editplaneName = document.querySelector("#editplaneName");
    const editDurationOption = document.querySelector("#editDurationOption");
    const editdiscountValue = document.querySelector("#editdiscountValue");
    const editdurationValue = document.querySelector("#editdurationValue");
    const editamount = document.querySelector("#editamount");
    const editplanBtn = document.querySelector("#editplanBtn");
    const editplus = document.querySelector("#editplus");
    const editminus = document.querySelector("#editminus");
    const editdiscountplus = document.querySelector("#editdiscountplus");
    const editdiscountminus = document.querySelector("#editdiscountminus");

    const addPlan = document.querySelector("#addPlan");
    const addPlancross = document.querySelector("#addPlancross");
    const addplanPopup = document.querySelector("#addplanPopup");
    const durationValue = document.querySelector("#durationValue");
    const plus = document.querySelector("#plus");
    const minus = document.querySelector("#minus");
    const addplanBtn = document.querySelector("#addplanBtn");
    const planeName = document.querySelector("#planeName");
    const DurationOption = document.querySelector("#DurationOption");
    const amount = document.querySelector("#amount");
    const adminCsrfToken = document.querySelector("#adminCsrfToken");
    
    const alertMessage = document.querySelector("#alertMessage");
    const p = document.querySelector("p");
    const tbody = document.querySelector("tbody");

    const discountValue = document.querySelector("#discountValue");
    const discountplus = document.querySelector("#discountplus");
    const discountminus = document.querySelector("#discountminus");
    tariffData(tbody,adminCsrfToken,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount);
    addPlancross.addEventListener("click",()=>{
        addPlan.classList.toggle("hidden");
    });
    editPlancross.addEventListener("click",()=>{
        editPlan.classList.toggle("hidden");
    });
    addplanPopup.addEventListener("click",()=>{
        addPlan.classList.remove("hidden");
    });
    plus.addEventListener("click",()=>{
        const numberr = Number(durationValue.value)+1;
       durationValue.value=numberr;
    });
    minus.addEventListener("click",()=>{
        let numberr='';
        if(durationValue.value>1){
             numberr = Number(durationValue.value)-1;
        }else{
             numberr = Number(durationValue.value);
        }
       durationValue.value=numberr;
    });
    discountplus.addEventListener("click",()=>{
        const numberr = Number(discountValue.innerHTML)+1;
       discountValue.innerHTML=numberr;
    });
    discountminus.addEventListener("click",()=>{
        let numberr='';
        if(discountValue.innerHTML>0){
             numberr = Number(discountValue.innerHTML)-1;
        }else{
             numberr = Number(discountValue.innerHTML);
        }
       discountValue.innerHTML=numberr;
    });
    //edit
        editplus.addEventListener("click",()=>{
        const numberr = Number(editdurationValue.value)+1;
       editdurationValue.value=numberr;
    });
    editminus.addEventListener("click",()=>{
        let numberr='';
        if(editdurationValue.value>1){
             numberr = Number(editdurationValue.value)-1;
        }else{
             numberr = Number(editdurationValue.value);
        }
       editdurationValue.value=numberr;
    });
    editdiscountplus.addEventListener("click",()=>{
        const numberr = Number(editdiscountValue.innerHTML)+1;
       editdiscountValue.innerHTML=numberr;
    });
    editdiscountminus.addEventListener("click",()=>{
        let numberr='';
        if(editdiscountValue.innerHTML>0){
             numberr = Number(editdiscountValue.innerHTML)-1;
        }else{
             numberr = Number(editdiscountValue.innerHTML);
        }
       editdiscountValue.innerHTML=numberr;
    });
    editplanBtn.addEventListener("click",()=>{
        //updated data 
            const updatedData = {
                unid:sanitize(editplanBtn.value),
                editplaneName:sanitize(editplaneName.value),
                editDurationOption:sanitize(editDurationOption.value),
                editdiscountValue:sanitize(editdiscountValue.innerHTML),
                editdurationValue:sanitize(editdurationValue.value),
                editamount:sanitize(editamount.value)
            };
            //check if data has changed
             const hasChanges = Object.keys(originalData).some(
                key => originalData[key] !== updatedData[key]
            );

            console.log(originalData,updatedData);
            if(hasChanges){
                async function addPlanFunction() {
                    updatedData.adminCsrfToken = sanitize(adminCsrfToken.value);
                    updatedData.editPlanStatus = true;
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
                            editplanBtn.disabled=true;
                        }, 2000);
                        //close modal and clear content
                        setTimeout(()=>{
                            alertMessage.classList.add("hidden");
                            alertMessage.classList.remove("flex");
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            editplanBtn.disabled=false;
                            DurationOption.value="";
                            planeName.value ="";
                            amount.value = "";
                            durationValue.value = "1";
                            discountValue.innerHTML  = "0";
                            editPlan.classList.add("hidden");
                            tariffData(tbody,adminCsrfToken,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount);
                        },2400);
                        
                    }else{
                        p.textContent = result.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex");
                        editplanBtn.disabled=false;
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
    addplanBtn.addEventListener("click",()=>{
        const adminCsrt = adminCsrfToken.value;
        console.log(amount.value)
        if(DurationOption.value!="default" && planeName.value!=="" && amount.value!==""){
            // success

            async function addPlanFunction() {
                const postData ={
                    addplanStatus:true,
                    DurationOption:sanitize(DurationOption.value),
                    planeName:sanitize(planeName.value),
                    amount:sanitize(amount.value),
                    durationValue:sanitize(durationValue.value),
                    discountValue:sanitize(discountValue.innerHTML),
                    adminCsrfToken:sanitize(adminCsrt)
                };
             const response = await fetch('fetch.php',{
                method:"POST",
                headers:{"Content-Type":"application/json"},
                body:JSON.stringify(postData)
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
                        addplanBtn.disabled=true;
                    }, 2000);
                    //close modal and clear content
                    setTimeout(()=>{
                        alertMessage.classList.add("hidden");
                        alertMessage.classList.remove("flex");
                        alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                        addplanBtn.disabled=false;
                        DurationOption.value="";
                        planeName.value ="";
                        amount.value = "";
                        durationValue.value = "1";
                        discountValue.innerHTML  ="0";
                        addPlan.classList.add("hidden");
                        tariffData(tbody,adminCsrfToken,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount);
                    },2400);
                    
                }else{
                     p.textContent = result.message;
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
                    }, 2400);
                }
             }
             catch(jsonErr){
                console.log("response error:" + jsonErr);
             }
          }
          addPlanFunction();
        }else{
            p.textContent = "all details are required";
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
            }, 2400);
        }
    });
});