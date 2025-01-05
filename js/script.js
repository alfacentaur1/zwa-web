// check if email is valid - must contain @ and .
function isEmailValid(e) {
    let test = document.getElementById("email");
    let s = document.getElementById("error_email");
    // if email do not contain . or @ function returns - 1 and if statement adds chyba class to email input
    //and prevents sending the document
    if (test.value.indexOf("@") === -1 || test.value.indexOf(".") === -1) { 
        e.preventDefault();
        test.classList.add("password");
        s.classList.add("error_hesla");
        
    }else {
        s.classList.remove("error_hesla");
        test.classList.remove("password");
    }
}
// Function to prevent submission if  "@" or "." is missing in the email or both
function isEmailSubmittable(e) {
    let test = document.getElementById("email");
    let k = document.getElementById("error_email");
    if ((test.value.indexOf("@") === -1 || test.value.indexOf(".") === -1) || 
    (test.value.indexOf("@") === -1 || test.value.indexOf(".") === -1)) {
        e.preventDefault();
        k.classList.add("error_hesla");

    }
}

// check if passwords match
function arePasswordsSame(e) {
    console.log("ahoj");
    let pas1 = document.getElementById("password");
    let pas2 = document.getElementById("password_znovu");

    if (pas1.value === pas2.value) {
        // password match
    }

    else {
        // passwords do not match, prevent submitting form
        console.log("hesla se neshoduji");
        e.preventDefault();
        let p = document.getElementById("error_hesla");
        p.classList.add("error_hesla");
        pas1.classList.add("password");
        pas2.classList.add("password");
    }
}
// validate the whole form before submission
function isFormSubmittable(e) {
    arePasswordsSame(e);
    isEmailValid(e);

}
// set event listeners
function main() {
    let email = document.querySelector("[name=email]");
    email.addEventListener("blur",isEmailValid);

    let form = document.querySelector("form");
    form.addEventListener("submit",isFormSubmittable);

}

// initialize the script
main();
