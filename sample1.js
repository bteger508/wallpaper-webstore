 
function validateAll() {
    errors = [];
    if (!passwordsMatch(getPassword(), getPasswordConfirm())) {
        errors.push("Passwords must match")
    }
    if (!passwordLength(getPassword())) {
        errors.push("Password must be at least 12 characters long")
    }

    if (errors.length > 0 ) {
        console.error(errors)
        return false
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

function passwordLength() {
    return document.getElementById('password').value.length >= 12
}

function getPassword() {
    password = document.getElementById('password').value
}

function getPasswordConfirm() {
    password = document.getElementById('pw-confirm').value
}

