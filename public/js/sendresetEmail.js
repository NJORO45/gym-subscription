function isValidEmail(value) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
}
addEventListener("DOMContentLoaded",()=>{
    const userResetEmail = document.querySelector("#userResetEmail");
    const resetUserBtn = document.querySelector("#resetUserBtn");
    const resetUserError = document.querySelector("#resetUserError");
    const userResetcross = document.querySelector("#userResetcross");
    const alertMessage = document.querySelector("#alertMessage");
    const userresetPasswordcsrtToken = document.querySelector("#userresetPasswordcsrtToken");
    const userresetPassword = document.querySelector("#userresetPassword");
    const p = document.querySelector("p");
    userResetcross.addEventListener("click",()=>{
        userresetPassword.classList.add("hidden");
    });
    resetUserBtn.addEventListener("click",()=>{
        const Csrt = userresetPasswordcsrtToken.value;
        if(!isValidEmail(userResetEmail.value)){
            resetUserError.classList.remove("text-gray-500");
            resetUserError.classList.add("text-red-500");
            resetUserError.innerHTML="Invalid email";
        }else{
            //valid email  A reset link will be sent to the above email if a match is found
            resetUserError.classList.remove("text-red-500");
            resetUserError.classList.add("text-gray-500");
            resetUserError.innerHTML="A reset link will be sent to the above email if a match is found";
            
            async function loginFunction() {
                const postData ={
                    userResetStatus:true,
                    userResetEmail:sanitize(userResetEmail.value),
                    csrtfToken:sanitize(Csrt)
                };
             const response = await fetch('php/sendresetEmail.php',{
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
                        userResetEmail.value="";
                        resetUserBtn.disabled=true;
                        alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                        userresetPassword.classList.add("hidden");
                        userresetPassword.classList.remove("flex");
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
                    }, 2400);
                }
             }
             catch(jsonErr){
                console.log("response error:" + jsonErr);
             }
          }
          loginFunction();

        }
    })
});