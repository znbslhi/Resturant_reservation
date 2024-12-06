
const hamburgerElm = document.getElementById('hamburger');
hamburgerElm.addEventListener('click', function() {
    var menu = document.getElementById('menu');
    menu.classList.toggle('show');

    // Toggle the color of the hamburger icon
    if (menu.classList.contains('show')) {
        hamburgerElm.style.color = '#FFB918';
    } else {
        hamburgerElm.style.color = ''; // Reset to original color
    }
});
