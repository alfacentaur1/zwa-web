// check if email is valid - must contain @ and .
function isEmailValid(e) {
    let test = document.getElementById("email");
    // if email do not contain . or @ function returns - 1 and if statement adds chyba class to email input
    //and prevents sending the document
    if (test.value.indexOf("@") === -1 || test.value.indexOf(".") === -1) { 
        test.classList.add("chyba");
        e.preventDefault();
        
    }
}
// Function to prevent submission if  "@" or "." is missing in the email or both
function isEmailSubmittable(e) {
    let test = document.getElementById("email");
    if ((test.value.indexOf("@") === -1 || test.value.indexOf(".") === -1) || 
    (test.value.indexOf("@") === -1 || test.value.indexOf(".") === -1)) {
        e.preventDefault();

    }
}

// check if passwords match
function arePasswordsSame(e) {
    let pas1 = document.getElementById("password");
    let pas2 = document.getElementById("password-znovu");

    if (pas1.value === pas2.value) {
        // password match
    }

    else {
        // passwords do not match, prevent submitting form
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
