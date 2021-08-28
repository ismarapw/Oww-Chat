/* ---------- Nav Toggler -------- */

// get nav bar elements
const nav = document.querySelector('nav.edit-profile');
const editToggle = document.querySelector('.profile-edit-toggle i');
const closeToggle = document.querySelector('.close-btn');

// add event for toggle
editToggle.addEventListener('click', ()=>{
    nav.classList.add('nav-appear');
});

closeToggle.addEventListener('click', ()=>{
    nav.classList.remove('nav-appear');
});


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
            }
        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}


/* ---------- Get Content Chat ---------- */

// get chat section
const chatSection = document.getElementsByClassName("conversation")[0];

// ajax function for fetch the chat content
function getContent(userIdValue){
    let xhr = new XMLHttpRequest();
    xhr.open('GET','script/ajax/ajax-get-content.php?userId='+userIdValue, true);
    xhr.send();
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            chatSection.innerHTML = xhr.responseText;
            
            if(chatSection.innerHTML.length > 0){
                // get send button
                const sendMsgBtn = chatSection.querySelector("#submit-message");
                
                // add event if send button is clicked
                sendMsgBtn.addEventListener('click',()=>{
                    // get message input value
                    const msgInput = chatSection.querySelector("#input-message");

                    // call send message function
                    sendMsg(msgInput.value, userIdValue);

                    // reset input value after message sent
                    msgInput.value = ""
                });
            }

        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}

/* ---------- Wait reply text message ---------- */

// get msg element
let userId = 0;

// ajax function to wait text message
function waitMsg(userIdValue){
    let xhr = new XMLHttpRequest();
    xhr.open('GET','script/ajax/ajax-wait-msg.php?userId='+userIdValue, true);
    xhr.send();
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            // add style for message status
            if(xhr.responseText.length > 0){
                // add text to conversation
                let newDivReply = document.createElement("div");
                let parent = document.querySelector(".conversation-area .container");
                newDivReply.classList.add("reply");
                newDivReply.innerHTML = "<p class='message'>"+xhr.responseText+"</p>";
                parent.appendChild(newDivReply);
                console.log(xhr.responseText);
            }
        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}


/* ---------- Search Somenone ----------*/

// get search element
const searchInput = document.getElementById("search-input");
const searchResult = document.getElementsByClassName("search-result")[0];

// ajax function for search
function search(inputValue){
    let xhr = new XMLHttpRequest();
    xhr.open('GET','script/ajax/ajax-search.php?inputVal='+inputValue, true);
    xhr.send();
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            // Fill search result with ajax response
            searchResult.innerHTML = xhr.responseText;

            // add style for search result
            if(searchResult.innerHTML.length > 0){
                searchResult.style.padding = "20px";

                // add event for user search result
                const users = document.querySelectorAll('.search-result .user');
                for(let user of users){
                    user.addEventListener('click',()=>{
                        // get id user
                        userId = user.querySelector("#user-id").innerHTML;

                        // get conversation 
                        getContent(userId);
                    });
                }
            }else {
                searchResult.style.padding = "0";
            }
        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}



// // add event for live message
// setInterval(() => {
//     if(chatSection.innerHTML.length > 0){
//         waitMsg(userId);
//     }
// }, 1000);


// add event for input field
searchInput.addEventListener('keyup', ()=>{
    search(searchInput.value);
});


