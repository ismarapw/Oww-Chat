// ---------- Nav Toggler -------- //
const nav = document.querySelector('nav.edit-profile');
const editToggle = document.querySelector('.profile-edit-toggle i');
const closeToggle = document.querySelector('.close-btn');

editToggle.addEventListener('click', ()=>{
    nav.classList.add('nav-appear');
});

closeToggle.addEventListener('click', ()=>{
    nav.classList.remove('nav-appear');
});