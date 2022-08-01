var toggle_icon = document.getElementById("theme-toggle");
var body = document.getElementsByTagName("body")[0];
var nav = document.getElementsByTagName("nav")[0];
var light = "fa-sun";
var dark = "fa-adjust";
var dark_theme_class = "dark-mode";
var navbar_dark = "navbar-dark";
var navbar_light = "navbar-white";

toggle_icon.addEventListener("click", function () {
    if (body.classList.contains(dark_theme_class)) {
        toggle_icon.classList.add(light);
        toggle_icon.classList.remove(dark);

        body.classList.remove(dark_theme_class);
        nav.classList.remove(navbar_dark);
        nav.classList.add(navbar_light);

        setCookie("theme", "light");
    } else {
        toggle_icon.classList.add(dark);
        toggle_icon.classList.remove(light);

        nav.classList.remove(navbar_light);
        body.classList.add(dark_theme_class);
        nav.classList.add(navbar_dark);

        setCookie("theme", "dark");
    }
});

function setCookie(name, value) {
    var d = new Date();
    d.setTime(d.getTime() + 365 * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}
