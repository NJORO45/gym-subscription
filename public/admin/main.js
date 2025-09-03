async function logoutStatusFunction() {
            const alertMessage = document.querySelector("#alertMessage");
            const p = document.querySelector("p");
            const response = await fetch('adminlogout.php',{
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
                    
                    setTimeout(() => {
                        window.location.href="../index.html";
                    }, 2500);
                }else{
                    //show logout alert
                    alertMessage.classList.remove("hidden");
                    alertMessage.classList.add("flex","animate-slide-down");
                    p.textContent="Error while loginout";
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
                }
            }
            catch(jsonErr){

            }
}
addEventListener("DOMContentLoaded",()=>{
    const adminlogout = document.querySelector("#adminlogout");
    const humbarger = document.querySelector("#humbarger");
    const humbargerMenu = document.querySelector("#humbargerMenu");
    adminlogout.addEventListener("click",()=>{
        logoutStatusFunction();
    });
    humbarger.addEventListener("click",()=>{
        console.log(window.innerWidth);
        console.log("clicked");
        if(window.innerWidth < 640){
            //small screens
            if(humbargerMenu.classList.contains("-left-full")){
                humbargerMenu.classList.remove("-left-full");
                humbargerMenu.classList.add("left-0");
            }else{
                humbargerMenu.classList.add("-left-full");
                humbargerMenu.classList.remove("left-0");
            }
        }else{
            if(humbargerMenu.classList.contains("sm:-left-64")){
                humbargerMenu.classList.remove("sm:-left-64");
                humbargerMenu.classList.add("sm:left-0");
            }else{
                humbargerMenu.classList.add("sm:-left-64");
                humbargerMenu.classList.remove("sm:left-0");
            }
            
        }
       
        if(humbarger.classList.contains("ri-menu-3-line")){
            humbarger.classList.remove("ri-menu-3-line");
            humbarger.classList.add("ri-close-large-line");
        }else{
            humbarger.classList.add("ri-menu-3-line");
            humbarger.classList.remove("ri-close-large-line");
        }
        
    });
});