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

/* ---------- Live friend list ---------- */

function liveFriend(liveSection){
    let xhr = new XMLHttpRequest();
    xhr.open('GET','script/ajax/ajax-life-friendlist.php', true);
    xhr.send();
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            liveSection.innerHTML = xhr.responseText;
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
                editStat.style.display = "flex";
                editStat.style.padding = "5px 0";
                setTimeout(() => {
                    editStat.style.display = "none";
                }, 3000);
            }else {
                editStat.style.padding = "0";
                document.location.href = 'list.php';
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



/* ---------- Live preview image edit ---------- */
const inputFile = document.querySelector("#image-input");
inputFile.addEventListener('change', ()=>{
    let file = inputFile.files;
    if(file.length > 0){
        let fileReader = new FileReader();
        fileReader.readAsDataURL(file[0]);
        fileReader.onload = (e)=>{
            console.log(e);
            document.querySelector(".edit-form img").setAttribute("src", e.target.result);
        }
    }
});