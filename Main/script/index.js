/* --------------Submit Login Form---------------- */

// get login elements
const formInputs = document.getElementById("form-inputs");
const submitBtn = document.getElementById("submit-button");

// ajax function for login
function submitForm(form){
    let xhr = new XMLHttpRequest();
    xhr.open('POST','script/ajax/ajax-login.php', true);
    xhr.send(form);
    xhr.onload = ()=>{
        if(xhr.readyState === 4 && xhr.status === 200){
            // get status of validation from html
            const status = document.getElementsByClassName("status")[0];

            // add status value from ajax
            status.innerHTML = xhr.responseText;

            // add style if status is appear or redirect if succesfull(no status appear)
            if(status.innerHTML.length > 0){
                status.style.display = "flex";
                status.style.padding = "5px 0";
                setTimeout(() => {
                    status.style.display = "none";
                }, 3000);
            }else {
                status.style.padding = "0";
                document.location.href = 'list.php';
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
