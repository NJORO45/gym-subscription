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
async function loginStatusFunction() {
    const userLogin = document.querySelector("#userLogin");
    const userprofile = document.querySelector("#userprofile");
    const response = await fetch('php/session_status.php',{
        method:"GET",
        headers:{"Accept":"application/json"}  
    });
    const text = await response.text();
    try{
        const results = JSON.parse(text);
        console.log(results)
        if(results.loggedIn){
            //session set for usr
            userLogin.classList.add("hidden");
            userprofile.classList.remove("hidden");
        }else{
            userLogin.classList.remove("hidden");
            userprofile.classList.add("hidden");
        }
    }
    catch(jsonErr){

    }
}
addEventListener("DOMContentLoaded",()=>{
   
    const alertMessage = document.querySelector("#alertMessage");
    const p = document.querySelector("p");
    const userLogin = document.querySelector("#userLogin");
    const loginPopup= document.querySelector("#loginPopup");
    const loginEmail= document.querySelector("#loginEmail");
    const loginPassword= document.querySelector("#loginPassword");
    const loginPassError= document.querySelector("#loginPassError");
    const loginEmailError= document.querySelector("#loginEmailError");
    const logincsrtfToken= document.querySelector("#logincsrtfToken");

    const signupPopup= document.querySelector("#signupPopup");
    
    //signup
    const Fname= document.querySelector("#Fname");
    const signupemail= document.querySelector("#signupemail");
    const Lname= document.querySelector("#Lname");
    const signupcsrtToken= document.querySelector("#signupcsrtToken");
    const tel= document.querySelector("#tel");
    const signupPassword= document.querySelector("#signupPassword");
    const confirmPassword= document.querySelector("#confirmPassword");
    const fNameError= document.querySelector("#fNameError");
    const lNameError= document.querySelector("#lNameError");
    const signupEmailError= document.querySelector("#signupEmailError");
    const telError= document.querySelector("#telError");
    const signuppasswordError= document.querySelector("#signuppasswordError");
    const passwordConfirmError= document.querySelector("#passwordConfirmError");
    let FnameStatus = false;
    let signupemailStatus = false;
    let LnameStatus = false;
    let telStatus = false;
    let passwordStatus = false;
    const signupBtn= document.querySelector("#signupBtn");
    const loginBtn= document.querySelector("#loginBtn");
    let emailStatus = false;
    console.log(signupcsrtToken.value);
    userLogin.addEventListener("click",()=>{
        loginPopup.classList.remove("hidden");
        loginPopup.classList.add("flex");
    });
    loginEmail.addEventListener("blur",()=>{
        const email = loginEmail.value;
        if(!isValidEmail(email)){
            loginEmailError.classList.remove("hidden");
            loginEmailError.textContent = 'Please enter a valid email';
            emailStatus=false;
        }else{
            loginEmailError.classList.add("hidden");
            loginEmailError.textContent = ' ';
            emailStatus=true;
        }
    });
    loginBtn.addEventListener("click",()=>{
        const signupToken = signupcsrtToken.value;
        if(emailStatus && loginPassword.value!=''){
            console.log("loginclicked pased");
            async function loginFunction() {
                const postData ={
                    loginStatus:true,
                    loginEmail:sanitize(loginEmail.value),
                    loginPassword:sanitize(loginPassword.value),
                    csrtfToken:sanitize(signupToken)
                };
             const response = await fetch('php/insertData.php',{
                method:"POST",
                headers:{"Content-Type":"application/json"},
                body:JSON.stringify(postData)
             });
             const text = await response.text();
             console.log(text);
             try{
                const result = JSON.parse(text);
               // console.log(result);
                if(result.success){
                    //login success
                    loginStatusFunction();
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
             }
             catch(jsonErr){
                console.log("response error:" + jsonErr);
             }
          }
          loginFunction();
        }else{
            loginBtn.disabled=false;
            alertMessage.classList.remove("hidden");
            alertMessage.classList.add("flex","animate-slide-down");
            p.textContent="Fill the form to login"
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
    //signup
    Fname.addEventListener("blur",()=>{
        console.log(Fname.value);
        if(Fname.value===''){
            fNameError.textContent="First name is required";
            FnameStatus=false;
        }else{
            fNameError.textContent="";
            FnameStatus=true;
        }
    });
    Lname.addEventListener("blur",()=>{
        console.log(Lname.value);
        if(Lname.value===''){
            lNameError.textContent="Last name is required";
            LnameStatus=false;
        }else{
            lNameError.textContent="";
            LnameStatus=true;
        }
    });
    signupemail.addEventListener("blur",()=>{
        console.log(Fname.value);
        if(!isValidEmail(signupemail.value)){
            signupEmailError.textContent="invalid email";
            signupemailStatus=false;
        }else{
            signupEmailError.textContent="";
            signupemailStatus=true;
        }
    });
    tel.addEventListener("blur",()=>{
        console.log(Fname.value);
        if(!validateAndFormatKenyanPhone(tel.value)){
            telError.textContent="invalid tel";
            telStatus=false;
        }else{
            telError.textContent="";
            telStatus=true;
        }
    });
     signupPassword.addEventListener("blur",()=>{
        console.log(Lname.value);
        if(signupPassword.value==='' || signupPassword.value=='0' || signupPassword.value=='1234'){
            signuppasswordError.textContent="Password is required";
        }else{
            signuppasswordError.textContent="";
        }
    });
    confirmPassword.addEventListener("input",()=>{
        console.log(confirmPassword.value);
        if(confirmPassword.value==='' && signupPassword.value===''){
            passwordConfirmError.textContent="Both passwords are required";
            passwordStatus=false;
        }else if(confirmPassword.value!=signupPassword.value){
            passwordConfirmError.textContent="no Match";
            passwordStatus=false;
        }else{
            passwordConfirmError.textContent='';
            passwordStatus=true;
        }
    });

        signupBtn.addEventListener("click",(e)=>{
            const signupToken = signupcsrtToken.value;
        if(FnameStatus && signupemailStatus && LnameStatus && telStatus && passwordStatus){
           signupBtn.disabled=true;
            async function signupFunction() {
                const postData ={
                    signupStatus:true,
                    Fname:sanitize(Fname.value),
                    Lname:sanitize(Lname.value),
                    signupemail:sanitize(signupemail.value),
                    tel:sanitize(tel.value),
                    confirmPassword:sanitize(confirmPassword.value),
                    csrtfToken:sanitize(signupToken.value)
                };
             const response = await fetch('php/insertData.php',{
                method:"POST",
                headers:{"Content-Type":"application/json"},
                body:JSON.stringify(postData)
             });
             const text = await response.text();
             console.log(text);
             try{
                const result = JSON.parse(text);
                console.log(result);
                if(result.success){
                    //login success
                    loginStatusFunction();
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
                        Fname.value="";
                        Lname.value="";
                        signupemail.value="";
                        tel.value="";
                        signupPassword.value="";
                        confirmPassword.value="";
                        signupBtn.disabled=false;
                        alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                        signupPopup.classList.add("hidden");
                        signupPopup.classList.remove("flex");
                    },2400);
                    //reload the page
                }else{
                    p.textContent = result.message;
                    alertMessage.classList.remove("hidden");
                    alertMessage.classList.add("flex");
                    // Fname.value="";
                    // Lname.value="";
                    // signupemail.value="";
                    // tel.value="";
                    // signupPassword.value="";
                    // confirmPassword.value="";
                    signupBtn.disabled=false;
                    alertMessage.classList.add("animate-slide-down");
                    setTimeout(() => {
                        alertMessage.classList.remove("animate-slide-down");
                        alertMessage.classList.add("animate-slide-up");
                    }, 2000);
                    setTimeout(() => {
                        alertMessage.classList.add("hidden","animate-slide-down");
                        alertMessage.classList.remove("flex","animate-slide-up");
                        // signupPopup.classList.add("hidden");
                        // signupPopup.classList.remove("flex");
                    }, 2400);
                }
             }
             catch(jsonErr){
                console.log("response error:" + jsonErr);
                signupBtn.disabled=false;
             }
          }
          signupFunction();
        }else{
            
            signupBtn.disabled=false;
            console.log(signupcsrtToken.value);
            alertMessage.classList.remove("hidden");
            alertMessage.classList.add("flex","animate-slide-down");
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