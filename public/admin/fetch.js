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
async function activeMembersData(activeMembers,adminCsrfToken) {
    const postData ={
        activeMembersData:true,
        adminCsrfToken:sanitize(adminCsrfToken.value)
    };
    try{
        const response =await fetch('fetch.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(postData)
        });
        const text = await response.text();
        console.log(text);
        try{
            const result = JSON.parse(text);
            if(result.success){
                activeMembers.textContent= result.active_members;
            }
        }catch(jsonErr){
            console.log("error from server:" + jsonErr);
        }
    }catch(error){
        console.log("error making activemember request:" + error);
    }
}
async function trainersData(trainers,adminCsrfToken) {
    const postData ={
        trainerData:true,
        adminCsrfToken:sanitize(adminCsrfToken.value)
    };
    try{
        const response =await fetch('fetch.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(postData)
        });
        const text = await response.text();
        console.log(text);
        try{
            const result = JSON.parse(text);
            if(result.success){
                trainers.textContent= result.active_members;
            }
        }catch(jsonErr){
            console.log("error from server:" + jsonErr);
        }
    }catch(error){
        console.log("error making activemember request:" + error);
    }
}
async function recentMembersData(tbody,adminCsrfToken) {
    const postData ={
        recentMembersData:true,
        adminCsrfToken:sanitize(adminCsrfToken.value)
    };
    try{
        const response =await fetch('fetch.php',{
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body:JSON.stringify(postData)
        });
        const text = await response.text();
        console.log(text);
        try{
            const result = JSON.parse(text);
            if(result.success){
                if(result.active_members.length>1){
                    const mapedData = result.active_members.map((items,index)=>{
                        return `
                        <tr>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${index +1}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.first_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.last_name}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.email}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.tel}</td>
                            <td class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap">${items.created_at}</td>
                        </tr>
                        `;
                }).join("");
                console.log(mapedData);
                tbody.innerHTML=mapedData;
                }
            }
        }catch(jsonErr){
            console.log("error from server:" + jsonErr);
        }
    }catch(error){
        console.log("error making activemember request:" + error);
    }
}
addEventListener("DOMContentLoaded",()=>{
    const adminCsrfToken = document.querySelector("#adminCsrfToken");
    const attendanceData = document.querySelector("#attendanceData");
    const expiringPlans = document.querySelector("#expiringPlans");
    const trainers = document.querySelector("#trainers");
    const monthlyRevenue = document.querySelector("#monthlyRevenue");
    const subscriptions = document.querySelector("#subscriptions");
    const activeMembers = document.querySelector("#activeMembers");
    const tbody = document.querySelector("tbody");

    activeMembersData(activeMembers,adminCsrfToken);
    trainersData(trainers,adminCsrfToken);
    recentMembersData(tbody,adminCsrfToken);
});