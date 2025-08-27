async function loginStatus() {
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
           // userLogin.classList.remove("hidden");
           // userprofile.classList.add("hidden");
        }else{
           // userLogin.classList.add("hidden");
            //userprofile.classList.remove("hidden");
        }
    }
    catch(jsonErr){

    }
}
addEventListener("DOMContentLoaded",()=>{
    loginStatus();
});