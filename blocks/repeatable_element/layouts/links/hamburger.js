var menu = document.getElementsByClassName('ccm-page')[0].getElementsByTagName('header')[0].getElementsByClassName('hamburger-menu')[0];
var icons = menu.getElementsByClassName('hamburger-icons')[0];
var hamburger = menu.getElementsByClassName('hamburger-menu-icon')[0];
var close = menu.getElementsByClassName('hamburger-close-icon')[0];

function activateNav() {
  menu.classList.toggle("active");
  hamburger.classList.toggle("active");
  close.classList.toggle("active");
}
icons.addEventListener("click", activateNav, false);
