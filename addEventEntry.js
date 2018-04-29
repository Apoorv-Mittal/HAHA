
function addEventEntry(email, id) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(id).innerHTML = this.responseText;
        }
        else {
            document.getElementById(id).innerHTML = "Something went wrong";
        }
    }
    xmlhttp.open("GET", "insert.php?id=" + id + "&email=" + email, true);
    xmlhttp.send();
}

function removeEntry(id) {
    $(id).toggle(3000);
    $(id).slideUp();
    $(id).remove();
}