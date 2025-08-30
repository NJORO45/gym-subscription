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

async function logoutStatusFunction() {
    const userLogin = document.querySelector("#userLogin");
            const userprofile = document.querySelector("#userprofile");
            const profileDropdown = document.querySelector("#profileDropdown");
            const alertMessage = document.querySelector("#alertMessage");
            const p = document.querySelector("p");
            const response = await fetch('logout.php',{
                method:"GET",
                headers:{"Accept":"application/json"}  
            });
            const text = await response.text();
            try{
                const results = JSON.parse(text);
                console.log(results)
                if(results.logout){
                    
                    //refresh CSRF TOKEN
                    setTimeout(()=>{
                            const csrtfToken = document.querySelectorAll(".csrtfToken");
                            async function csrtfTokenFunction() {
                                const response = await fetch('csrfTokenGenerator.php',{
                                    method:"GET",
                                    headers:{"Accept":"application/json"}     
                                });
                                const text = await response.text();
                                console.log(text);
                                try{
                                    const results = JSON.parse(text);
                                    if(results){
                                        csrtfToken.forEach((e)=>{
                                            e.value=results.csrfToken;
                                        });
                                    }
                                }catch(jsonErr){
                                    console.log(" json error:" + jsonErr);
                                }
                            }
                            csrtfTokenFunction();
                            window.location.href = "../index.html";

                    },2500);
               
                }else{
                    userLogin.classList.remove("hidden");
                    userprofile.classList.add("hidden");
                }
            }
            catch(jsonErr){

            }
}

addEventListener("DOMContentLoaded",()=>{
    const changePasswordBtn = document.querySelector("#changePasswordBtn");
    const ConfirmNewPassword = document.querySelector("#ConfirmNewPassword");
    const newPassword = document.querySelector("#newPassword");
    const oldPassword = document.querySelector("#oldPassword");
    const confirmpassError = document.querySelector("#confirmpassError");
    const newpassError = document.querySelector("#newpassError");
    const oldpassError = document.querySelector("#oldpassError");
    let oldPasswordStatus=false;
    let newPasswordStatus=false;
    let ConfirmNewPasswordStatus=false;
    let selectedValue = null;
    const alertMessage = document.querySelector("#alertMessage");
    const csrtftokenpaswordReset = document.querySelector("#csrtftokenpaswordReset");
    const csrtftokenpreference = document.querySelector("#csrtftokenpreference");
    const saveOptionBtn = document.querySelector("#saveOptionBtn");
    const SelectedOption = document.getElementsByName("notification");
    const deleteAccountBtn = document.querySelector("#deleteAccountBtn");
    const deactivateAccount = document.querySelector("#deactivateAccount");
    const deactivateTrue = document.querySelector("#deactivateTrue");
    const deactivatecsrtToken = document.querySelector("#deactivatecsrtToken");
    const p = document.querySelector("p");
    deleteAccountBtn.addEventListener("click",()=>{
        deactivateAccount.classList.remove("hidden");
        deactivateAccount.classList.add("flex");

    });
    deactivateTrue.addEventListener("click",()=>{
        const token = deactivatecsrtToken.value;
            async function deactivateAccountFunction() {
            try{
                const postData = {
                    deactivateAccountStatus:true,
                    csrtfToken:sanitize(token)
                    
                };
                const response = await fetch('insertData.php',{
                    method:"POST",
                    headers:{"Content-Type":"application/json"},
                    body:JSON.stringify(postData)
                });
                const text = await response.text();
                try{
                    const results = JSON.parse(text);
                    if(results.success){
                        // success
                        p.textContent = results.message;
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
                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                            loginPopup.classList.add("hidden");
                            loginPopup.classList.remove("flex");
                        },2400);
                        logoutStatusFunction();
                    }else{
                        p.textContent = results.message;
                        alertMessage.classList.remove("hidden");
                        alertMessage.classList.add("flex");
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
                    console.log("server error: " + jsonErr);
                }
            }catch(error){
                console.log("error runing reset function: " + error);
            }
        }
        deactivateAccountFunction();
    });
    saveOptionBtn.addEventListener("click",()=>{
        SelectedOption.forEach(radio=>{
            if(radio.checked){
                selectedValue = radio.value;
               // console.log(selectedValue);
                const token = csrtftokenpreference.value;
                    async function preferenceFunction() {
                    try{
                        const postData = {
                            preferenceStatus:true,
                            selectedValue:sanitize(selectedValue),
                            csrtfToken:sanitize(token)
                            
                        };
                        const response = await fetch('insertData.php',{
                            method:"POST",
                            headers:{"Content-Type":"application/json"},
                            body:JSON.stringify(postData)
                        });
                        const text = await response.text();
                        try{
                            const results = JSON.parse(text);
                            if(results.success){
                                //login success
                                p.textContent = results.message;
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
                                    alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                                    loginPopup.classList.add("hidden");
                                    loginPopup.classList.remove("flex");
                                },2400);
                            }else{
                                p.textContent = results.message;
                                alertMessage.classList.remove("hidden");
                                alertMessage.classList.add("flex");
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
                            console.log("server error: " + jsonErr);
                        }
                    }catch(error){
                        console.log("error runing reset function: " + error);
                    }
                }
                preferenceFunction();
            }else{
                p.textContent = "Select an option to continue";
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
                }, 2400);
            }
        });
    });
    oldPassword.addEventListener("blur",()=>{
        if(oldPassword.value===""){
            oldpassError.textContent="Old password is required";
            oldPasswordStatus=false;
        }else{
            oldpassError.textContent="";
            oldPasswordStatus=true;
        }
    });
     newPassword.addEventListener("blur",()=>{
        if(newPassword.value===""){
            newpassError.textContent="Old password is required";
            newPasswordStatus=false;
        }else{
            newpassError.textContent="";
            newPasswordStatus=true;
        }
    });
     ConfirmNewPassword.addEventListener("input",()=>{
        if(newPassword.value==ConfirmNewPassword.value){
            confirmpassError.textContent="";
            ConfirmNewPasswordStatus=true;
        }else{
            confirmpassError.textContent="Password doesn't match";
            ConfirmNewPasswordStatus=false;
        }
    });
    changePasswordBtn.addEventListener("click",()=>{
        const token = csrtftokenpaswordReset.value;
        if(oldPasswordStatus && newPasswordStatus && ConfirmNewPasswordStatus){
            async function passwordResetFunction() {
                try{
                    const postData = {
                        passwordResetStatus:true,
                        oldpassword:sanitize(oldPassword.value),
                        confirmnewpassword:sanitize(ConfirmNewPassword.value),
                        csrtfToken:sanitize(token)
                        
                    };
                    const response = await fetch('insertData.php',{
                        method:"POST",
                        headers:{"Content-Type":"application/json"},
                        body:JSON.stringify(postData)
                    });
                    const text = await response.text();
                    try{
                        const results = JSON.parse(text);
                        if(results.success){
                            //login success
                            p.textContent = results.message;
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
                                loginBtn.disabled=false;
                                oldPassword.value="";
                                newPassword.value="";
                                ConfirmNewPassword.value="";
                                alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                                loginPopup.classList.add("hidden");
                                loginPopup.classList.remove("flex");
                            },2400);
                        }else{
                            p.textContent = results.message;
                            alertMessage.classList.remove("hidden");
                            alertMessage.classList.add("flex");
                            loginBtn.disabled=false;
                            oldPassword.value="";
                            newPassword.value="";
                            ConfirmNewPassword.value="";
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
                        console.log("server error: " + jsonErr);
                    }
                }catch(error){
                    console.log("error runing reset function: " + error);
                }
            }
            passwordResetFunction();
        }else{
            p.textContent = "Check your inputs";
            alertMessage.classList.remove("hidden");
            alertMessage.classList.add("flex");
            signupBtn.disabled=false;
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
    })
});