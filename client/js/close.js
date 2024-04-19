window.addEventListener("unload", function (event) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../client/logout.php", true);
    xhr.send();
});
