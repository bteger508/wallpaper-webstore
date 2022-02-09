const errors = [];
document.getElementById('registerForm').addEventListener('submit', validateAll)

function validateAll(event) {
    
    if (!passwordsMatch(getPassword(), getPasswordConfirm())) {
        errors.push("Passwords must match")
    }
    if (!passwordLength(getPassword())) {
        errors.push("Password must be at least 12 characters long")
    }

    if(!checkUsername(getUsername())) {
        errors.push("Username must be at least 8 characters long with only numbers and letters")
    }

    if (errors.length > 0 ) {
        console.error(errors);
        document.getElementById("registerErrors").innerHTML = ''
        for(err of errors) {
            document.getElementById("registerErrors").innerHTML += "<p>" + err + "</p>"
        }
        while(errors.length > 0) {
            errors.pop();
        }
        event.preventDefault()
    }

    return true
}

// Passwords: 12 chars (2 digits, 2 special)
function validPassword(pw) {
    let containsNums = /.*(\d).*(\d)/; 
    return containsNums.test(pw)
}

function passwordsMatch(pw1, pw2) {
    return pw1 === pw2
}

function passwordLength(pw) {
    return pw.length >= 12
}

function checkUsername(username) {
    let valid = /([a-z]|[0-9]){8,}/
    return valid.test(username)
}

// Getters

function getUsername() {
    return document.getElementById('username').value
}

function getFirstName() {
    return document.getElementById('fname').value
}

function getPassword() {
    return document.getElementById('password').value
}

function getPasswordConfirm() {
    return document.getElementById('pwConfirm').value
}

// Setters

function setErrorsOnHtml(errors) {
    document.getElementById('registerErrors').value = errors
}
