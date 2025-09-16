async function fetchPlanFunction(planContainer,plancsrtToken) {
            const alertMessage = document.querySelector("#alertMessage");
            const p = document.querySelector("p");
            const response = await fetch('php/fetchplan.php',{
                method:"GET",
                headers:{"Accept":"application/json"}  
            });
            const text = await response.text();
            try{
                const results = JSON.parse(text);
                const mapedData = results.plan.map((e)=>{
                    return `
                      <div class="flex flex-col bg-slate-50 w-full md:w-auto  shadow-lg max-w-xs h-auto rounded-xl overflow-hidden">
                            <div class="flex flex-col bg-orange-400 text-white text-center py-6">
                                <h1 class="text-2xl text-center text-bold">${e.name}</h1>
                                  ${
                                        e.discount > 0
                                        ? `
                                            <div class="flex flex-col items-center">
                                            <p class="text-lg line-through opacity-70">KES ${e.tariff}</p>
                                            <p class="mt-1 text-3xl font-extrabold">
                                                KES ${(e.tariff - (e.tariff * e.discount / 100)).toFixed(2)}
                                            </p>
                                            </div>
                                            <p class="text-xs opacity-80">Discount ${e.discount}%</p>
                                        `
                                        : `
                                            <p class="mt-2 text-3xl font-extrabold">KES ${e.tariff}</p>
                                        `
                                    }
                                <p class="text-sm opacity-80">For ${e.duration_value} ${e.duration_type} </p>
                            </div>
                            <div class="px-6 py-4 flex-grow">
                                <ul class="space-y-3 text-gray-600 text-sm">
                                   ${
                                     e.features.map(data=>
                                        `<li>✅${data}</li>`
                                     ).join("")
                                   }
                                    
                                </ul>
                            </div>
                            <div class="text-center my-6">
                                <button id="enrollplanBtn" value="${e.unid}" href="#" class=" bg-orange-500 text-gray-100 py-2 px-4 rounded-full hover:bg-orange-600 inline-block transform transition duration-200 hover:-translate-y-1">Enroll now</button>
                            </div>
                        </div>
                    `;
                }).join("");
                planContainer.innerHTML =mapedData;
                const enrollplanBtn = document.querySelectorAll("#enrollplanBtn");
                
                enrollplanBtn.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                        const button = e.currentTarget;
                        let planunid = e.currentTarget.value
                        const element = e.currentTarget.parentElement.parentElement;
                        let planName = element.querySelector("h1").innerHTML;
                        const csrtToken = plancsrtToken.value;
                        async function subscriptionSetion() {
                            try{
                                const response = await fetch('php/subscriptionstatus.php',{
                                    method:"GET",
                                    headers:{"Accept":"application/json"}
                                });
                                const text = await response.text();
                                //console.log(text);
                                try{
                                    const result= JSON.parse(text);
                                    if(result.loggedIn){
                                        if(result.hasPlan){
                                            console.log(result)
                                            //already on a plan
                                            p.textContent = result.message;
                                            alertMessage.classList.remove("hidden");
                                            alertMessage.classList.add("flex");
                                            button.disabled=true;
                                            alertMessage.classList.add("animate-slide-down");
                                            setTimeout(() => {
                                                alertMessage.classList.remove("animate-slide-down");
                                                alertMessage.classList.add("animate-slide-up");
                                            }, 2000);
                                            setTimeout(() => {
                                                alertMessage.classList.add("hidden","animate-slide-down");
                                                alertMessage.classList.remove("flex","animate-slide-up");
                                                button.disabled=false;
                                            }, 2400);
                                        }else{
                                            //enroll
                                            console.log("no plan")
                                            async function subscribeplan() {
                                                const postData ={
                                                    sabscribeStatus:true,
                                                    planUnid:sanitize(planunid),
                                                    planName:sanitize(planName),
                                                    csrtfToken:sanitize(csrtToken)
                                                };
                                                console.log(postData);
                                            try{
                                                const response = await fetch('php/insertData.php',{
                                                    method:"POST",
                                                    headers:{"Content-Type":"application/json"},
                                                    body:JSON.stringify(postData)
                                                });
                                                const text = await response.text();
                                                console.log(text);
                                                try{
                                                    const result= JSON.parse(text);
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
                                                            button.disabled=true;
                                                            alertMessage.classList.remove("animate-slide-down","animate-slide-up");
                                                            loginPopup.classList.add("hidden");
                                                            loginPopup.classList.remove("flex");
                                                        },2400,()=>{e.currentTarge.disabled=false;},2500);
                                                    }else{
                                                        p.textContent = result.message;
                                                        alertMessage.classList.remove("hidden");
                                                        alertMessage.classList.add("flex");
                                                        button.disabled=false;
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
                                                }catch(jsonErr){
                                                    console.log("server response:"+ jsonErr);
                                                }
                                            }catch(error){
                                                console.log("anable to run function:"+ error);
                                            }
                                            
                                        }
                                        subscribeplan();
                                        }
                                    }else{
                                        //login to sabscrib to plan
                                        p.textContent = "login to enroll";
                                        alertMessage.classList.remove("hidden");
                                        alertMessage.classList.add("flex");
                                        button.disabled=false;
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
                                }catch(jsonErr){
                                    console.log("server response:"+ jsonErr);
                                }
                            }catch(error){
                                console.log("anable to run function:"+ error);
                            }
                            
                        }
                        subscriptionSetion();
                    });
                });
            }
            catch(jsonErr){

            }
}
addEventListener("DOMContentLoaded",()=>{
    const planContainer = document.querySelector("#planContainer");
    const plancsrtToken = document.querySelector("#plancsrtToken");
    const alertMessage = document.querySelector("#alertMessage");
    const p = document.querySelector("p");
    //fetch plans fro plan table
    fetchPlanFunction(planContainer,plancsrtToken,alertMessage,p);
});