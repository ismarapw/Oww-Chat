/* --------------Submit Register Form---------------- */

// get register elements
const formInputs = document.getElementById("form-inputs");
const submitBtn = document.getElementById("submit-button");

// ajax function for register
function submitForm(form){
    let xhr = new XMLHttpRequest();
    xhr.open('POST','script/ajax/ajax-register.php', true);
    xhr.send(form);
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            // get status of validation from html
            const status = document.getElementsByClassName("status")[0];

            // add status value from ajax
            status.innerHTML = xhr.responseText;

            // Redirect if succesfull
            if(status.innerHTML.length === 0){
                document.location.href = 'chats.php';
            }
        }else{
            console.log("Error Server Not Found or Busy");
        }
    }
}

// on submit event
submitBtn.addEventListener('click', ()=>{
    let formToBeSubmit = new FormData(formInputs);
    submitForm(formToBeSubmit);
});
