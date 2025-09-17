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
addEventListener("DOMContentLoaded",()=>{
    const emailSubscriptionBtn = document.querySelector("#emailSubscriptionBtn");
    const emailSubscription = document.querySelector("#emailSubscription");
    const suggestionOpener = document.querySelector("#suggestionOpener");
    const suggestionPopup = document.querySelector("#suggestionPopup");
    const sugestioncsrtfToken = document.querySelector("#sugestioncsrtfToken");
    const SubscriptioncsrtfToken = document.querySelector("#SubscriptioncsrtfToken");
    const suggestionText = document.querySelector("#suggestionText");
    const subscriptionError = document.querySelector("#subscriptionError");
    const sugestionError = document.querySelector("#sugestionError");
    const suggestionBtn = document.querySelector("#suggestionBtn");
    const alertMessage = document.querySelector("#alertMessage");
    const p = document.querySelector("p");

    suggestionOpener.addEventListener("click",()=>{
        suggestionPopup.classList.toggle("hidden");
    });
    emailSubscriptionBtn.addEventListener("click",()=>{
        if(emailSubscription.value=="" || !isValidEmail(emailSubscription.value)){
            subscriptionError.innerHTML="Invalid input";
            
        }else{
            subscriptionError.innerHTML="";
            const Subscriptioncsrtf = SubscriptioncsrtfToken.value;
            async function subscriptionFunction() {
                try{
                    const postData ={
                    emailSubscriptionStatus:true,
                    emailSubscription:sanitize(emailSubscription.value),
                    csrtfToken:sanitize(Subscriptioncsrtf)
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
                        if(result.success){
                            suggestionBtn.disabled=true;
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
                                suggestionBtn.disabled=false;
                                alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                                suggestionPopup.classList.add("hidden");
                                suggestionPopup.classList.remove("flex");
                                emailSubscription.value="";
                            },2400);
                        }else{
                            p.textContent = result.message;
                            alertMessage.classList.remove("hidden");
                            alertMessage.classList.add("flex");
                            suggestionBtn.disabled=false;
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
                                emailSubscription.value="";
                            }, 2400);
                        }
                    }catch(jsonErr){
                        console.log("server error:"+ jsonErr);
                    }

                }catch(error){
                    console.log("anable to run function:"+ error);
                }
            }
            subscriptionFunction();

        }
    });
    suggestionBtn.addEventListener("click",()=>{
        if(suggestionText.value==""){
            sugestionError.innerHTML="Input is requred";
            
        }else{
            sugestionError.innerHTML="";
            const sugestioncsrtf = sugestioncsrtfToken.value;
            async function suggestionFunction() {
                try{
                    const postData ={
                    suggestionTextStatus:true,
                    suggestionText:sanitize(suggestionText.value),
                    csrtfToken:sanitize(sugestioncsrtf)
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
                        if(result.success){
                            suggestionBtn.disabled=true;
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
                                suggestionBtn.disabled=false;
                                alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                                suggestionPopup.classList.add("hidden");
                                suggestionPopup.classList.remove("flex");
                            },2400);
                        }else{
                            p.textContent = result.message;
                            alertMessage.classList.remove("hidden");
                            alertMessage.classList.add("flex");
                            suggestionBtn.disabled=false;
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
                        console.log("server error:"+ jsonErr);
                    }

                }catch(error){
                    console.log("anable to run function:"+ error);
                }
            }
            suggestionFunction();

        }
    });
});