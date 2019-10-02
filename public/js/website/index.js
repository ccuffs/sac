var menuMobile = document.querySelector(".menu-mobile")
var toggleButton = document.querySelector(".navbar__toggle-button");

toggleButton.addEventListener('click', function () {
    menuMobile.classList.toggle('menu-mobile--opened')
})


function isElementInView(element) {
    let viewTop = window.scrollY;
    let viewBot = viewTop + window.innerHeight;

    let elemTop = element.offsetTop;
    let elemBot = elemTop + element.clientHeight;

    return ((elemTop <= (viewBot - 200)) && (elemBot >= viewTop));
}


window.onload = function(event) {
    let elements = document.querySelectorAll("#intro [scroll-sensitive]");

    elements.forEach(element => {
        let className = element.getAttribute("scroll-sensitive");
        element.classList.add(className);
    });
}


window.onscroll = function(event) {
    let sections = document.getElementsByTagName("section");
    for (let section of sections) {

        let elements = document.querySelectorAll("#" + section.id + " [scroll-sensitive]");

        if (isElementInView(section)) {
            elements.forEach(element => {
                let className = element.getAttribute("scroll-sensitive");
                element.classList.add(className);
            });
        }
    }
}

let idName = document.querySelector("#idName");

if (idName != null){
    idName.addEventListener('keyup', function(){
        let intValue = parseInt(this.value);
    
        if (!isNaN(intValue)){
            $(this).mask('000.000.000-00');
        }
        else
            $(this).unmask();
    });
}
