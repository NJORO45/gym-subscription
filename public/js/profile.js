async function fetchProfile() {
    try{
        const response = await fetch('profileData.php',{
            method:"GET",
            header:{"Accept":"application/json"}
        });
        const text= await response.text();
        try{
            const results = JSON.parse(text);
           return results;
        }catch(jsonErr){
            console.log("error fetching data:" + jsonErr);
        }

    }catch(error){
        console.log("error occured when runing function:" + error);
    }
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
        //leaned.substring(1); will strip the leading 0
        return  cleaned;
    } else {
        return null; // invalid number
    }
}
addEventListener("DOMContentLoaded",async()=>{
    const csrtftokenProfile = document.querySelector("#csrtftokenProfile");
    const saveBtn = document.querySelector("#saveBtn");
    const joinDate = document.querySelector("#joinDate");
    const Fname = document.querySelector("#Fname");
    const Lname = document.querySelector("#Lname");
    const tel = document.querySelector("#tel");
    const email = document.querySelector("#email");
    const alertMessage = document.querySelector("#alertMessage");
    const subscriptionPlan = document.querySelector("#subscriptionPlan");
    const planExpiryDate = document.querySelector("#planExpiryDate");
    const p = document.querySelector("p");
    let fnamestatus=false;
    let lnamestatus=false;
    let emailstatus=false;
    let telstatus=false;
    const data = await fetchProfile();
    Fname.addEventListener("blur",()=>{
        if(Fname.value.trim()===""){
            fnamestatus=false;
        }else{
            fnamestatus=true;
        }
    });
    Lname.addEventListener("blur",()=>{
        if(Lname.value.trim()===""){
            lnamestatus=false;
        }else{
            lnamestatus=true;
        }
    });
    email.addEventListener("blur",()=>{
        if(!isValidEmail(email.value)){
            emailstatus=false;
        }else{
            emailstatus=true;
        }
    });
    tel.addEventListener("blur",()=>{
        if(!validateAndFormatKenyanPhone(tel.value)){
            telstatus=false;
        }else{
            telstatus=true;
        }
    });
    if(data.success){
        joinDate.textContent = data.messag[0].created_at;
        Fname.value = data.messag[0].first_name;
        Lname.value = data.messag[0].last_name;
        tel.value = data.messag[0].tel;
        email.value = data.messag[0].email;
        //store original data
         const originalData = {
            first_name: data.messag[0].first_name,
            last_name: data.messag[0].last_name,
            tel: data.messag[0].tel,
            email: data.messag[0].email
        };
        saveBtn.addEventListener("click",()=>{
            //updated data
            const updatedData = {
                first_name: Fname.value,
                last_name: Lname.value,
                tel: tel.value,
                email: email.value
            };
            //check if data has changed
             const hasChanges = Object.keys(originalData).some(
                key => originalData[key] !== updatedData[key]
            );
            if(hasChanges && (fnamestatus || lnamestatus || emailstatus || telstatus)){
              //update changes to database
              const postData = {
                profileUpdate:true,
                csrtfToken:csrtftokenProfile.value,
                first_name: Fname.value,
                last_name: Lname.value,
                tel: tel.value,
                email: email.value
              };
                async function updatePprofile() {
                    try{
                        const response = await fetch('insertData.php',{
                            method:"POST",
                            headers:{"Content-Type":"application/json"},
                            body:JSON.stringify(postData)
                        });
                        const text = await response.text();
                        console.log(text);
                        try{
                            const result = JSON.parse(text);
                            if(result.success){
                                p.textContent = result.message;
                                alertMessage.classList.remove("hidden");
                                alertMessage.classList.add("flex","animate-slide-down");
                                setTimeout(() => {
                                    alertMessage.classList.remove("animate-slide-down");
                                    alertMessage.classList.add("animate-slide-up");
                                }, 2000);
                                //close modal and clear content
                                setTimeout(()=>{
                                    alertMessage.classList.add("hidden");
                                    alertMessage.classList.remove("flex");
                                    loginEmail.value="";
                                    loginPassword.value="";
                                    loginBtn.disabled=false;
                                    alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                                    loginPopup.classList.add("hidden");
                                    loginPopup.classList.remove("flex");
                                },2400);
                            }else{
                                p.textContent = result.message;
                                alertMessage.classList.remove("hidden");
                                alertMessage.classList.add("flex");
                                loginBtn.disabled=false;
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
                        }catch(jsonErr){
                            console.log("error fon server" +jsonErr);
                        }
                    }catch(error){
                        console.log("error ocured while updating data" + error);
                    }
                }
                updatePprofile();
            }else{
                 alertMessage.classList.remove("hidden");
                alertMessage.classList.add("flex","animate-slide-down");
                p.textContent="No changes found"
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
    }else{
        console.log("error accesing profile");
    }
    // const csrtToken = plancsrtToken.value;
    async function subscriptionSetion() {
        try{
            const response = await fetch('subscriptionstatus.php',{
                method:"GET",
                headers:{"Accept":"application/json"}
            });
            const text = await response.text();
            try{
                const result= JSON.parse(text);
                if(result.hasPlan){
                    subscriptionPlan.textContent = result.plan_name;
                    planExpiryDate.textContent=result.expiryDate;
                }else{
                    subscriptionPlan.textContent = "no subscription";
                    planExpiryDate.textContent="NA";
                }
                    
            }catch(jsonErr){
                console.log("server response:"+ jsonErr);
            }
        }catch(error){
            console.log("anable to run function:"+ error);
        }
        
    }
    subscriptionSetion();

    
});