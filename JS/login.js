document.getElementsByClassName("login-wrapper")[0].classList.add("has-focus");

document.getElementsByClassName("login-wrapper")[0].addEventListener("click", function() {
    document.getElementsByClassName("login-wrapper")[0].classList.add("has-focus");
    document.getElementsByClassName("login-wrapper")[0].classList.remove("not-focus");
});