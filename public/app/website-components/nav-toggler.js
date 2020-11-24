var toggleNavbar = document.getElementById('navbarTogglerClickArea');
var navArea = document.getElementById('navbarTogglerVisibleArea');
toggleNavbar.addEventListener('click', function (event) {
  if (navArea.classList.contains('collapse')) {
    navArea.classList.remove('collapse');
    navArea.classList.add('show');
  } else if (navArea.classList.contains('show')) {
    navArea.classList.remove('show');
    navArea.classList.add('collapse');
  }
});
