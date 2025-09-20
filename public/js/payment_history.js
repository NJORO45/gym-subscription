
async function paymentHistoryFunction(tbody) {
           
            const response = await fetch('payment_history.php',{
                method:"GET",
                headers:{"Accept":"application/json"}  
            });
            const text = await response.text();
            try{
                const result = JSON.parse(text);
                if(result.success){
                if(result.message.length>0){
                    const mapedData = result.message.map((items)=>{
                        return `
                        <tr class="space-x-2">
                            <td class="p-2 whitespace-nowrap sticky left-0 z-10 bg-white">${items.Receipt_no}</td>
                            <td class="p-2 whitespace-nowrap ">${items.subscription }</td>
                            <td class="p-2 whitespace-nowrap ">${items.amount }</td>
                            <td class="p-2 whitespace-nowrap ">none</td>
                            <td class="p-2 whitespace-nowrap ">${items.dateAdded }</td>
                            <td colspan="2">
                                <a href="receipt.php?id=${items.Receipt_no}" id="downloadReceipt" class="text-xs bg-orange-400 p-1 text-white rounded-full hover:bg-orange-600">Download</a>
                            </td>
                        </tr>
                    `
                        ;
                }).join("");
                tbody.innerHTML=mapedData;
            }else {
                     tbody.innerHTML=`
                      <tr>
                            <td colspan="9" class="bg-gray-50 p-2 text-sm text-gray-900 whitespace-nowrap text-center">No payment history </td>
                        </tr>
                    `;
                    
                }
                //edit whitelist
                const downloadReceipt = document.querySelectorAll("#downloadReceipt");
                downloadReceipt.forEach(btn=>{
                    btn.addEventListener("click",e=>{
                        const receiptNumber = e.currentTarget.value
                        console.log("downloadReceipt",receiptNumber);
                    });
                });

            }else{
                }
            }
            catch(jsonErr){

            }
}
addEventListener("DOMContentLoaded",()=>{
    const alertMessage = document.querySelector("#alertMessage");
    const tbody = document.querySelector("tbody");
    const p = document.querySelector("p");
    

paymentHistoryFunction(tbody); 
    
});