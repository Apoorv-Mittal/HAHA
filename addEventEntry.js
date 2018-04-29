
function addEventEntry(x, email, id) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(id).innerHTML = this.responseText;
        }
        else {
            document.getElementById(id).innerHTML = "Something went wrong";
        }
    }
    xmlhttp.open("POST", "insert.php?id=" + id + "&email=" + email, true);
    xmlhttp.send();
}

function removeEntry(start,id) {
    $("#"+id).toggle("slow");
    setTimeout(1000, () => ($("#" + id).remove()));
}