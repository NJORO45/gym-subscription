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
addEventListener("DOMContentLoaded",()=>{
    const newPassword = document.querySelector("#newPassword");
    const password = document.querySelector("#password");
    const ConfirmpasswordError = document.querySelector("#ConfirmpasswordError");
    const resetPasswordBtn = document.querySelector("#resetPasswordBtn");
    const alertMessage = document.querySelector("#alertMessage");
    const userresetPasswordcsrtToken = document.querySelector("#userresetPasswordcsrtToken");
    const p = document.querySelector("p");
    const passwordError = document.querySelector("#passwordError");
    const view = document.querySelectorAll("#view");
    let newPasswordState=false;
    view.forEach(btn=>{
        btn.addEventListener("click",(e)=>{
            const element =e.currentTarget.parentElement;
            const input = element.querySelector("input");
            const inerView = element.querySelector("#view");
            if(input.type=="password"){
                input.type="text";
                inerView.classList.remove("ri-eye-off-line");
                inerView.classList.add("ri-eye-line");
            }else{
                input.type="password";
                inerView.classList.remove("ri-eye-line");
                inerView.classList.add("ri-eye-off-line");
            }

        });
    });
    password.addEventListener("blur",()=>{
        if(password.value===""){
            passwordError.innerHTML="password required";
        }else{
            passwordError.innerHTML="";
        }
    });
    newPassword.addEventListener("input",()=>{
        console.log("input")
        if(password.value==newPassword.value){
            ConfirmpasswordError.innerHTML="";
            newPasswordState=true
        }else{
            ConfirmpasswordError.innerHTML="No match";
            newPasswordState=false;
        }
    });
    resetPasswordBtn.addEventListener("click",()=>{
        //crst token
        const Csrt = userresetPasswordcsrtToken.value;
        console.log(userresetPasswordcsrtToken.value)
        if(newPasswordState){
                 async function resetUserPasswordFunction() {
                const postData ={
                    passwordResetStatus:true,
                    newPassword:sanitize(newPassword.value),
                    csrtfToken:sanitize(Csrt)
                };
             const response = await fetch('insertData.php',{
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
                        resetPasswordBtn.disabled=true;
                        alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                        loginPopup.classList.add("hidden");
                        loginPopup.classList.remove("flex");
                    },2400);
                    setTimeout(()=>{
                        window.location.href="../index.html";
                    },2500);
                }else{
                     p.textContent = result.message;
                    alertMessage.classList.remove("hidden");
                    alertMessage.classList.add("flex");
                    resetPasswordBtn.disabled=false;
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
          resetUserPasswordFunction();
        }else{
            p.textContent = "Check your password";
            alertMessage.classList.remove("hidden");
            alertMessage.classList.add("flex");
            resetPasswordBtn.disabled=false;
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