const menu = document.querySelector('.menu');
const slidemenu = document.querySelector('.slidemenu');

menu.addEventListener("click", function () {
    if (menu.classList.contains('open')) {
        menu.classList.remove('open');
        slidemenu.classList.remove('open');
    } else {
        menu.classList.add('open');
        slidemenu.classList.add('open');
    }
})

