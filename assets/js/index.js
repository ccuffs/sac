var menu= document.getElementById("menu")
var btn= document.getElementById("button")
btn.addEventListener('click',function(){
    menu.classList.toggle('menu-mobile__open').style.transition="0.4s ease"
})
