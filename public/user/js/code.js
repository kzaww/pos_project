const btn = document.querySelector('.scroll_up');

window.onscroll = () => {
    if (document.body.scrollTop > 400 || document.documentElement.scrollTop > 400) {
        btn.classList.add('show');
    } else {
        btn.classList.remove('show');
    }
}

btn.onclick = () => {
    document.body.scrollIntoView({
        behavior: 'smooth'
    })
}

// document.addEventListener('click',e=>{
//     let dropdownBtn = e.target.matches("[data-dropdown-button]");

//     if(!dropdownBtn && e.target.closest('[data-dropdown]') != null) return;

//     let currentDrop
//     if(dropdownBtn){
//         currentDrop = e.target.closest('[data-dropdown]');
//         currentDrop.classList.toggle('active');
//     }

//     document.querySelectorAll('[data-dropdown].active').forEach(dropdown =>{
//         if(dropdown ===currentDrop)return
//         dropdown.classList.remove('active')
//     });
// })

const dropdownBtn = document.querySelector('#dropdown_btn'),
    dropdown = document.querySelector('#dropdown');

document.onclick = (e) => {
    if (e.target.id !== 'dropdown_btn' && e.target.id !== 'dropdown') {
        dropdownBtn.classList.remove('active');
        dropdown.classList.remove('active');
    }
}

dropdownBtn.onclick = function() {
    dropdownBtn.classList.toggle('active');
    dropdown.classList.toggle('active');
}