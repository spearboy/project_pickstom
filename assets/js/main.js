const menu = document.querySelector('.menu');

menu.addEventListener("click", function () {
    if (menu.classList.contains('open')) {
        menu.classList.remove('open');
    } else {
        menu.classList.add('open');
    }
})
