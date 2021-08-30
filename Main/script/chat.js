/* ---------- Global Variabel for user target id -------- */

var userIdTarget = 0;

/* ---------- Nav Toggler -------- */

// get nav bar elements
const nav = document.querySelector('nav.edit-profile');
const editToggle = document.querySelector('.profile-edit-toggle i');
const closeToggle = document.querySelector('.close-btn i');

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

                // scroll to bottom
                let height = chatSection.querySelector(".conversation-area").scrollHeight;
                chatSection.querySelector(".conversation-area").scrollTo(0, height);            
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
            
            if(chatSection.querySelector(".start-message") === null){
                // add event on mobile width
                const content = document.querySelector("main.conversation");
                const sideBar = document.querySelector("aside.persons-chat");
                if(window.innerWidth < 768){
                    const backBtn = document.querySelector(".ri-arrow-left-line");
                    
                    content.style.display = "block";
                    content.style.width = "100%"; 
                    sideBar.style.width = "0%";

                    backBtn.addEventListener('click', ()=>{
                        content.style.display = "none";
                        content.style.width = "0%"; 
                        sideBar.style.width = "100%";
                    });
                }else{
                    const backBtn = document.querySelector(".ri-arrow-left-line");
                    backBtn.style.display = "none";
                }



                // get send button
                const sendMsgBtn = chatSection.querySelector("#submit-message");

                // scroll to bottom
                let height = chatSection.querySelector(".conversation-area").scrollHeight;
                chatSection.querySelector(".conversation-area").scrollTo(0, height);

                
                // add event if send button is clicked
                sendMsgBtn.addEventListener('click',()=>{
                    // get message input value
                    const msgInput = chatSection.querySelector("#input-message");

                    // call send message function
                    sendMsg(msgInput.value, userIdValue);

                    // reset input value after message sent
                    msgInput.value = ""; 
                });


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
                        userIdTarget = user.querySelector(".user-id-res").innerHTML;

                        // get conversation 
                        getContent(userIdTarget);

                        // close search box
                        searchResult.style.display = "none";
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

// add event for input field
searchInput.addEventListener('keyup', ()=>{
    searchResult.style.display = "block";
    search(searchInput.value);
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
    if(chatSection.querySelector(".start-message") === null){
        // get live component
        const liveSection = document.querySelector(".conversation-area .container");
        liveMsg(liveSection, userIdTarget);
    }
}, 1000);



/* ---------- Live friend list ---------- */

function liveFriend(liveSection){
    let xhr = new XMLHttpRequest();
    xhr.open('GET','script/ajax/ajax-life-friendlist.php', true);
    xhr.send();
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            liveSection.innerHTML = xhr.responseText;

            // get friend list element
            const friendList = liveSection.getElementsByClassName("friend-content");

            // add event for friend list
            for (let i = 0 ; i < friendList.length ; i++){
                friendList[i].addEventListener('click', ()=>{
                    // get id user
                    userIdTarget = friendList[i].querySelector(".user-id").innerHTML;

                    // get conversation 
                    getContent(userIdTarget);
                });
            }
        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}

setInterval(() => {
    // get live component
    const liveFriendList = document.querySelector(".friends .container");
    liveFriend(liveFriendList);

}, 1000);



/* ---------- Ajax Edit Profile ---------- */
// get edit component

const editBtn = document.querySelector(".edit-form .submit");

function editProfile(editVal){
    let xhr = new XMLHttpRequest();
    xhr.open('POST','script/ajax/ajax-edit-profile.php', true);
    xhr.send(editVal);
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            // get status from html
            const editStat = document.querySelector(".edit-status");
            
            // add status value from ajax
            editStat.innerHTML = xhr.responseText;

            // add style if status is appear or redirect if succesfull(no status appear)
            if(editStat.innerHTML.length > 0){
                editStat.style.padding = "5px 0";
            }else {
                editStat.style.padding = "0";
                document.location.href = 'chat.php';
            }

        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}


editBtn.addEventListener('click',()=>{
    const editForm = document.querySelector(".edit-form form");
    const sentForm = new FormData(editForm);

    editProfile(sentForm);
});

