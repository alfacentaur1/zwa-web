function initForm(){
    const username = document.getElementById("username");
    username.addEventListener("keyup",checkUsername);
}


function checkUsername(e) {
    const xhr = new XMLHttpRequest();
    const inputUsername = document.getElementById("username").value;
    xhr.addEventListener("load",validateUsername);
    xhr.open("POST","https://zwa.toad.cz/~kopecfi3/semestralka/users_ajax.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("username="+ encodeURIComponent(inputUsername));
    console.log("Sending AJAX request with username: ", inputUsername);
}

function validateUsername(e) {
    console.log("Server response:", e.target.responseText);
    const p = document.getElementById("hidden");
    const name = document.getElementById("username");
    if (e.target.responseText == "used") {
        p.classList.add("ajax");
        name.classList.add("chyba");
    }else if (e.target.responseText == "not_used"){
        p.classList.remove("ajax");
        name.classList.remove("chyba");
        
    }
}

document.addEventListener("DOMContentLoaded", initForm);