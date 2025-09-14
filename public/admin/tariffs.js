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
async function tariffData(tbody,adminCsrfToken,deleteplanpopup,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount) {
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
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.tariff}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.discount}%</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center flex flex-row gap-2">
                               <button id="editBtn" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${items.unid}">Edit</button>
                               <button id="removeBtn" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${items.unid}">Remove</button>
                            </td>
                        </tr>
                        `;
                }).join("");
                tbody.innerHTML=mapedData;
                }else if(result.tariffs.length==1){
                    tbody.innerHTML=`
                      <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">1</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].duration_value} ${result.tariffs[0].duration_type}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].tariff}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].tariff}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${result.tariffs[0].discount}%</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 text-center flex flex-row gap-2">
                               <button id="editBtn" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.tariffs[0].unid}">Edit</button>
                               <button id="removeBtn" class="bg-orange-400 text-white  shadow-lg rounded-full px-2 py-1 text-xs hover:bg-orange-600 cursor-pointer" type="button" name="this" value="${result.tariffs[0].unid}">Remove</button>
                            </td>
                        </tr>
                    `;
                }else{
                    tbody.innerHTML=`
                      <tr>
                            <td colspan="9" class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap text-center">no plans found</td>
                        </tr>
                    `;
                }
                
                const editBtn = document.querySelectorAll("#editBtn");
                const removeBtn = document.querySelectorAll("#removeBtn");
                  const deleteplanBtn = document.querySelector("#deleteplanBtn");
                removeBtn.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                        console.log("delete")
                        const planName = document.querySelector("#planName");
                        const planDuration = document.querySelector("#planDuration");
                        const planTarif = document.querySelector("#planTarif");
                        deleteplanpopup.classList.remove("hidden");
                        const unid = e.currentTarget.value;
                        const data = result.tariffs.find(plan =>plan.unid === unid);
                        planTarif.value=data.tariff;
                        planName.value=data.name;
                        deleteplanBtn.value=data.unid;
                        planDuration.value=data.duration_value + " " + data.duration_type;
                    });
                });
                editBtn.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                        editPlan.classList.remove("hidden");
                        const unid = e.currentTarget.value;
                        const data = result.tariffs.find(plan =>plan.unid === unid);
                        console.log(data)
                        editplaneName.value=data.name;
                        editDurationOption.value=data.duration_type;
                        editdiscountValue.value=data.discount;
                        editdurationValue.value=data.duration_value;
                        editamount.value=data.tariff;
                        editplanBtn.value=data.unid;
                        console.log(data.features.length)
                        // Loop features and create inputs
                        //  Clear old inputs first
                         const container = document.getElementById("editfeaturesContainer");
                        container.innerHTML = "";
                        data.features.forEach((feature, index) => {
                           
                            const input = document.createElement("input");
                            input.type = "text";
                            input.name = "features[]";
                            input.value = feature; 
                            input.placeholder = `Feature ${index}`;
                            input.className = "border-2 outline-none px-2 py-1 rounded-lg w-full";
                            container.appendChild(input);
                        });
                        //store original data
                         originalData = {
                            unid:data.unid,
                            editplaneName:data.name,
                            editDurationOption:data.duration_type,
                            editdiscountValue:data.discount,
                            editdurationValue:String(data.duration_value),
                            features:data.features,
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
    
    const planName = document.querySelector("#planName");
    const planDuration = document.querySelector("#planDuration");
    const planTarif = document.querySelector("#planTarif");
    const deleteplanpopup = document.querySelector("#deleteplanpopup");
    const deletepopupcross = document.querySelector("#deletepopupcross");
    const deleteplanBtn = document.querySelector("#deleteplanBtn");
    

    const alertMessage = document.querySelector("#alertMessage");
    const p = document.querySelector("p");
    const tbody = document.querySelector("tbody");

    const discountValue = document.querySelector("#discountValue");
    const discountplus = document.querySelector("#discountplus");
    const discountminus = document.querySelector("#discountminus");
    
    tariffData(tbody,adminCsrfToken,deleteplanpopup,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount);

    document.getElementById("addFeatureBtn").addEventListener("click", function() {
        const container = document.getElementById("featuresContainer");
        const input = document.createElement("input");
        input.type = "text";
        input.name = "features[]";  // important: array so PHP/JS backend gets multiple values
        input.placeholder = `Feature ${container.children.length + 1}`;
        input.className = "border-2 outline-none px-2 py-1 rounded-lg w-full";
        input.id = `Description${container.children.length + 1}`; // unique id
        container.appendChild(input);
        });
        document.getElementById("removeFeatureBtn").addEventListener("click", function() {
        const container = document.getElementById("featuresContainer");
        //only remove if there is more than one container
        if(container.children.length>1){
            container.removeChild(container.lastElementChild);
        }
        });
    document.getElementById("editaddFeatureBtn").addEventListener("click", function() {
        const container = document.getElementById("editfeaturesContainer");
        const input = document.createElement("input");
        input.type = "text";
        input.name = "features[]";  // important: array so PHP/JS backend gets multiple values
        input.placeholder = `Feature ${container.children.length + 1}`;
        input.className = "border-2 outline-none px-2 py-1 rounded-lg w-full";
        input.id = `editDescription${container.children.length + 1}`; // unique id
        container.appendChild(input);
        });
        document.getElementById("editremoveFeatureBtn").addEventListener("click", function() {
        const container = document.getElementById("editfeaturesContainer");
        //only remove if there is more than one container
        if(container.children.length>1){
            container.removeChild(container.lastElementChild);
        }
        });

    deletepopupcross.addEventListener("click",()=>{
        deleteplanpopup.classList.toggle("hidden");
        console.log("delete")
    });
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
        const features = document.querySelectorAll("#editfeaturesContainer input[name='features[]']");
        let allFeaturesFilled = true;
          // Check if any feature is empty
         // Collect all features
        let featuresArray = [];
        features.forEach(f => {
            console.log(f);
            if (f.value.trim() === "") {
                allFeaturesFilled = false;
            } else {
                featuresArray.push(sanitize(f.value));
            }
        });
        console.log(features);
        console.log(featuresArray);

        //updated data 
            const updatedData = {
                unid:sanitize(editplanBtn.value),
                editplaneName:sanitize(editplaneName.value),
                editDurationOption:sanitize(editDurationOption.value),
                editdiscountValue:sanitize(editdiscountValue.innerHTML),
                editdurationValue:sanitize(editdurationValue.value),
                features:featuresArray,
                editamount:sanitize(editamount.value)
            };
            //check if data has changed to deeply check the diference
             const hasChanges = Object.keys(originalData).some(key => {
            if (Array.isArray(originalData[key]) && Array.isArray(updatedData[key])) {
                return JSON.stringify(originalData[key]) !== JSON.stringify(updatedData[key]);
            }
            return originalData[key] !== updatedData[key];
            });
            //to deeply check the diference
            console.log("Original:", JSON.stringify(originalData, null, 2));
            console.log("Updated:", JSON.stringify(updatedData, null, 2));

            if(hasChanges){
                console.log("changed")
                async function addPlanFunction() {
                    updatedData.adminCsrfToken = sanitize(adminCsrfToken.value);
                    updatedData.editPlanStatus = true;
                    updatedData.features = featuresArray;
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
                            tariffData(tbody,adminCsrfToken,deleteplanpopup,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount);
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
    deleteplanBtn.addEventListener("click",()=>{
        const adminCsrt = adminCsrfToken.value;
            async function deletePlanFunction() {
                const postData ={
                    deleteplanStatus:true,
                    deleteplanunid:sanitize(deleteplanBtn.value),
                    adminCsrfToken:sanitize(adminCsrt)
                };
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
                        deleteplanBtn.disabled=true;
                    }, 2000);
                    //close modal and clear content
                    setTimeout(()=>{
                        alertMessage.classList.add("hidden");
                        alertMessage.classList.remove("flex");
                        alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                        deleteplanBtn.disabled=false;
                        planTarif.value="";
                        planName.value="";
                        planDuration.value="";
                        deleteplanpopup.classList.add("hidden");
                        tariffData(tbody,adminCsrfToken,deleteplanpopup,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount);
                    },2400);
                    
                }else{
                     p.textContent = result.message;
                    alertMessage.classList.remove("hidden");
                    alertMessage.classList.add("flex");
                    deleteplanBtn.disabled=false;
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
          deletePlanFunction();
       
          
    });
        addplanBtn.addEventListener("click",()=>{
        const adminCsrt = adminCsrfToken.value;
      console.log("addplanBtn")
      const features = document.querySelectorAll("#featuresContainer input[name='features[]']");
        let allFeaturesFilled = true;
          // Check if any feature is empty
         // Collect all features
        let featuresArray = [];
        features.forEach(f => {
            console.log(f);
            if (f.value.trim() === "") {
                allFeaturesFilled = false;
            } else {
                featuresArray.push(sanitize(f.value));
            }
        });
        if(DurationOption.value!="default" && planeName.value!=="" && amount.value!=="" &&allFeaturesFilled){
            // success

            async function addPlanFunction() {
                const postData ={
                    addplanStatus:true,
                    DurationOption:sanitize(DurationOption.value),
                    planeName:sanitize(planeName.value),
                    amount:sanitize(amount.value),
                    durationValue:sanitize(durationValue.value),
                    discountValue:sanitize(discountValue.innerHTML),
                    features: featuresArray,
                    adminCsrfToken:sanitize(adminCsrt)
                };
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
                        tariffData(tbody,adminCsrfToken,editfeaturesContainer,editPlan,editplanBtn,editplaneName,editDurationOption,editdiscountValue,editdurationValue,editamount);
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
          
        console.log(features);
        console.log(featuresArray);
        
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