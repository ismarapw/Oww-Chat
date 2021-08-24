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

                const user = document.querySelectorAll('.search-result .user');
                console.log(user);
                for(let i of user){
                    i.addEventListener('click',()=>{
                        console.log("haii");
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
    search(searchInput.value);
});


