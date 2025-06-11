function password() {
    var password = document.getElementById("password");
    var viewPassword = document.getElementById("visible");
    if (password.type === "password") {
        password.type = "text";
       viewPassword.textContent = "visibility_off";
    }
    else {
        password.type = "password";
        viewPassword.textContent = "visibility";
    }
}