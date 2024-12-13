// initialize form and set event listerners
function initForm(){
    const username = document.getElementById("username"); // get username from doc
    username.addEventListener("keyup",checkUsername); // add listener to keyup
}

// check username avalaibility
function checkUsername(e) {
    //create new xml object and get the value from input
    const xhr = new XMLHttpRequest();
    const inputUsername = document.getElementById("username").value;

    // when the request is completed
    xhr.addEventListener("load",validateUsername);

    // open and send to server endpoint
    xhr.open("POST","https://zwa.toad.cz/~kopecfi3/semestralka/users_ajax.php");
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("username="+ encodeURIComponent(inputUsername));
}

// handle server response, check if username is taken
function validateUsername(e) {
    // get the hidden input and name input and set the class chyba if the username is taken
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


// after DOM is fully loaded, initialize the form
document.addEventListener("DOMContentLoaded", initForm);