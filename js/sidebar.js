let arrow = document.querySelectorAll(".arrow");
for (var i = 0; i < arrow.length; i++) {
  arrow[i].addEventListener("click", (e) => {
    let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
    arrowParent.classList.toggle("showMenu");
  });
}




// Menu Collapse
let sidebar = document.querySelector(".sidebar");

window.onresize = responsiveMenu;
window.onload = responsiveMenu;

function responsiveMenu() {

  if (window.innerWidth < 768) {
    sidebar.classList.add("close");
  } else if (window.innerWidth > 768) {
    sidebar.classList.remove("close");
  }

}

var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
  return new bootstrap.Dropdown(dropdownToggleEl)
})