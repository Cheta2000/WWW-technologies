var document;
var window;
var hamburger = document.getElementById("hamburger");
var links = document.getElementById("hidden");
hamburger.onclick = function() {
    if (links.style.display === "block") {
        links.style.display = "none";
    } else {
        links.style.display = "block";
    }
};
window.onresize = function() {
    if (window.innerWidth > 1000) {
        links.style.display = "block";
    } else {
        links.style.display = "none";
    }
};