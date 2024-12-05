function isEmailValid(e) {
    let test = document.getElementById("email");
    if (test.value.indexOf("@") === -1 || test.value.indexOf(".") === -1) {
        test.classList.add("chyba");
        e.preventDefault();
        
    }
}
//kdyz chybi @ a . nemuzeme submittnout
function isEmailSubmittable(e) {
    let test = document.getElementById("email");
    if (test.value.indexOf("@") === -1 && test.value.indexOf(".") === -1) {
        e.preventDefault();

    }
}

//shoduji se hesla?
function arePasswordsSame(e) {
    let pas1 = document.getElementById("password");
    let pas2 = document.getElementById("password-znovu");

    if (pas1.value === pas2.value) {
        //vse ok
    }

    else {
        console.log(pswrds);
        e.preventDefault();
        let p = document.getElementById("error_hesla");
        p.classList.add("error_hesla");
        pas1.classList.add("password");
        pas2.classList.add("password");
    }
}

function isFormSubmittable(e) {
    arePasswordsSame(e);
    isEmailValid(e);

}

function main() {
    let email = document.querySelector("[name=email]");
    email.addEventListener("blur",isEmailValid);

    let form = document.querySelector("form");
    form.addEventListener("submit",isFormSubmittable);

}

main();



