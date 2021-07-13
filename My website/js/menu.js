var document;
var window;
var hamburger = document.getElementById("hamburger");
var links = document.getElementById("hidden");
var buttonRight = document.getElementById("right");
var buttonLeft = document.getElementById("left");
var section = 0;
var last = false;

buttonLeft.onclick = function() {
    if (section != 0) {
        last = false;
        disable();
        section--;
        show();
    }
}
buttonRight.onclick = function() {
    if (!last) {
        disable();
        section++;
        show();
    }
}

function disable() {
    for (let i = 12 * section + 1; i <= 12 * (section + 1); i++) {
        var article = document.getElementById(i.toString());
        if (article != null) {
            article.style.display = "none";
        }
    }
}

function show() {
    for (let i = 12 * section + 1; i <= 12 * (section + 1); i++) {
        var article = document.getElementById(i.toString());
        if (article != null) {
            article.style.display = "block";
        } else {
            last = true;
        }
    }
}

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