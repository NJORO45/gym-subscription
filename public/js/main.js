addEventListener("DOMContentLoaded",()=>{
    const loginLink= document.querySelectorAll("#loginLink");
    const adminLoginLink= document.querySelectorAll("#adminLoginLink");
    const signupLink= document.querySelectorAll("#signupLink");

    const userprofile = document.querySelector("#userprofile");
    const profileContainer = document.querySelector("#userProfileContainer");
    const profileDropdown = document.querySelector("#profileDropdown");

    const signupPopup= document.querySelector("#signupPopup");
    const adminLogin= document.querySelector("#adminLogin");
    const loginPopup= document.querySelector("#loginPopup");
    const adminresetPassword= document.querySelector("#adminresetPassword");
    const userresetPassword= document.querySelector("#userresetPassword");

    const adminForgetPassword= document.querySelector("#adminForgetPassword");
    const resetPassword= document.querySelector("#resetPassword");

    const cross= document.querySelectorAll("#cross");
    signupLink.forEach(loginL => {
        loginL.addEventListener("click",()=>{
            signupPopup.classList.remove("hidden");
            signupPopup.classList.add("flex");
            loginPopup.classList.remove("flex");
            loginPopup.classList.add("hidden");
            adminLogin.classList.remove("flex");
            adminLogin.classList.add("hidden");
        });
    });
    loginLink.forEach(loginL => {
        loginL.addEventListener("click",()=>{
            signupPopup.classList.add("hidden");
            signupPopup.classList.remove("flex");
            loginPopup.classList.add("flex");
            loginPopup.classList.remove("hidden");
            adminLogin.classList.remove("flex");
            adminLogin.classList.add("hidden");
        });
    });
    adminLoginLink.forEach(loginL => {
        loginL.addEventListener("click",()=>{
            signupPopup.classList.add("hidden");
            signupPopup.classList.remove("flex");
            loginPopup.classList.add("hidden");
            loginPopup.classList.remove("flex");
            adminLogin.classList.add("flex");
            adminLogin.classList.remove("hidden");
        });
    });
      
    adminForgetPassword.addEventListener("click",()=>{
        signupPopup.classList.add("hidden");
        signupPopup.classList.remove("flex");
        loginPopup.classList.add("hidden");
        loginPopup.classList.remove("flex");
        adminLogin.classList.add("hidden");
        adminLogin.classList.remove("flex");
        adminresetPassword.classList.add("flex");
        adminresetPassword.classList.remove("hidden");
    });
    resetPassword.addEventListener("click",()=>{
        signupPopup.classList.add("hidden");
        signupPopup.classList.remove("flex");
        loginPopup.classList.add("hidden");
        loginPopup.classList.remove("flex");
        adminLogin.classList.add("hidden");
        adminLogin.classList.remove("flex");
        adminresetPassword.classList.add("hidden");
        adminresetPassword.classList.remove("flex");
        userresetPassword.classList.add("flex");
        userresetPassword.classList.remove("hidden");
    });
    cross.forEach(btn=>{
        btn.addEventListener("click",e=>{
            e.currentTarget.parentElement.parentElement.parentElement.classList.remove("flex");
            e.currentTarget.parentElement.parentElement.parentElement.classList.add("hidden");
        });
    });

    profileContainer .addEventListener("click",(e)=>{
        e.preventDefault();
        profileDropdown.classList.toggle("hidden");
    });
      //  close dropdown if clicked outside
    document.addEventListener("click", (e) => {
        if (!profileContainer.contains(e.target) && !profileDropdown.contains(e.target)) {
            profileDropdown.classList.add("hidden");
        }
    });
});