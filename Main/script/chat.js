
/* ---------- Add some event ---------- */

// scroll to bottom
let height = document.querySelector(".conversation-area").scrollHeight;
document.querySelector(".conversation-area").scrollTo(0, height);

// global variable for user target
const userIdTarget = document.querySelector(".user-target-id").innerHTML;

// back button toggle
const backbtn = document.querySelector(".ri-arrow-left-line");
backbtn.addEventListener('click',()=>{document.location.href = "list.php";});


/* ---------- Send text message ---------- */

// get status message
const msgStatus = document.getElementsByClassName("message-status")[0];


// ajax function to send text message
function sendMsg(msgValue, userIdValue){

    let xhr = new XMLHttpRequest();
    xhr.open('GET','script/ajax/ajax-send-msg.php?msgValue='+msgValue+'&userDestId='+userIdValue, true);
    xhr.send();

    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            msgStatus.innerHTML = xhr.responseText;

            // add style for message status
            if(msgStatus.innerHTML.length > 0){
                msgStatus.style.padding = "5px 0";
            }else {
                msgStatus.style.padding = "0";

                // add text to conversation
                let newDivSend = document.createElement("div");
                let parent = document.querySelector(".conversation-area .container");
                newDivSend.classList.add("sent");
                newDivSend.innerHTML = "<p class='message'>"+msgValue+"</p>";
                parent.appendChild(newDivSend);

                // scroll to bottom
                let height = document.querySelector(".conversation-area").scrollHeight;
                document.querySelector(".conversation-area").scrollTo(0, height);            
            }
        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}

// get send button
const sendMsgBtn = document.querySelector("#submit-message");

// add event if send button is clicked
sendMsgBtn.addEventListener('click',()=>{
    // get message input value
    const msgInput = document.querySelector("#input-message");

    // call send message function
    sendMsg(msgInput.value, userIdTarget);

    // reset input value after message sent
    msgInput.value = ""; 
});



/* ---------- Live text message ---------- */

// ajax function to wait text message
function liveMsg(liveSection, userIdValue){
    let xhr = new XMLHttpRequest();
    xhr.open('GET','script/ajax/ajax-live-msg.php?userId='+userIdValue, true);
    xhr.send();
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            liveSection.innerHTML = xhr.responseText;
        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}


// add event for live message
setInterval(() => {
    // get live component
    const liveSection = document.querySelector(".conversation-area .container");
    liveMsg(liveSection, userIdTarget);

}, 1000);



