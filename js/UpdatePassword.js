function validateForm() {
    var email = document.getElementById("Email").value;
    var newPassword = document.getElementById("UpdatePassword").value;
    var confirmPassword = document.getElementById("ConfirmPassword").value;

    
    if (email.trim() === "") {
        alert("Please enter your email.");
        return false;
    }

     
    if (newPassword.trim() === "") {
        alert("Please enter your new password.");
        return false;
    }

     
    if (confirmPassword.trim() === "") {
        alert("Please confirm your new password.");
        return false;
    }

     
    if (newPassword !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

     
    return true;
}
