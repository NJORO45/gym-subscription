
async function logoutStatusFunction() {
    const userLogin = document.querySelector("#userLogin");
            const userprofile = document.querySelector("#userprofile");
            const profileDropdown = document.querySelector("#profileDropdown");
            const alertMessage = document.querySelector("#alertMessage");
            const p = document.querySelector("p");
            const response = await fetch('logoutmain.php',{
                method:"GET",
                headers:{"Accept":"application/json"}  
            });
            const text = await response.text();
            try{
                const results = JSON.parse(text);
                console.log(results)
                if(results.logout){
                    //show logout alert
                    alertMessage.classList.remove("hidden");
                    alertMessage.classList.add("flex","animate-slide-down");
                    p.textContent="Logging Out...";
                    //hide alert after animation
                    setTimeout(() => {
                        alertMessage.classList.remove("animate-slide-down");
                        alertMessage.classList.add("animate-slide-up");
                    }, 2000);

                    setTimeout(() => {
                        alertMessage.classList.add("hidden");
                        alertMessage.classList.remove("flex","animate-slide-up");
                        alertMessage.classList.add("animate-slide-down");
                        
                    }, 2400);
                    setTimeout(()=>{
                        userLogin.classList.remove("hidden");
                        userprofile.classList.add("hidden");
                        profileDropdown.classList.add("hidden");
                    },2450);
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
                            location.reload();

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
    const logoutBtn = document.querySelector("#logoutBtn");
    logoutBtn.addEventListener("click",()=>{
           logoutStatusFunction();
    });
    
    
});