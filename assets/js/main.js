const menu = document.querySelector('.menu');
// const menu2 = document.querySelector(".")

menu.addEventListener("click", function () {
    if (menu.classList.contains('open')) {
        menu.classList.remove('open');
        // menu2.style.rigth = '-'
    } else {
        menu.classList.add('open');
        // menu2.style.rigth = '0'
    }
})
