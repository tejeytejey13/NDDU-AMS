window.addEventListener("unload", function (event) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../client/update-status.php", true);
    xhr.send();
});
