async function fetchPlanFunction(planContainer) {
            const alertMessage = document.querySelector("#alertMessage");
            const p = document.querySelector("p");
            const response = await fetch('php/fetchplan.php',{
                method:"GET",
                headers:{"Accept":"application/json"}  
            });
            const text = await response.text();
            console.log(text)
            try{
                const results = JSON.parse(text);
                console.log(results)
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
                                <button value="${e.unid}" href="#" class=" bg-orange-500 text-gray-100 py-2 px-4 rounded-full hover:bg-orange-600 inline-block transform transition duration-200 hover:-translate-y-1">Enroll now</button>
                            </div>
                        </div>
                    `;
                }).join("");
                planContainer.innerHTML =mapedData;
            }
            catch(jsonErr){

            }
}
addEventListener("DOMContentLoaded",()=>{
    const planContainer = document.querySelector("#planContainer");
    //fetch plans fro plan table
    fetchPlanFunction(planContainer);
});