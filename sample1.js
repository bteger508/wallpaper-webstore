function validateAll() {
    errors = [];
    if (!validateNoEmptyFields()) {
        errors.push("No empty fields")
    }
    if (!passwordsMatch()) {
        errors.push("Passwords must match")
    }
    if (!passwordLength) {
        errors.push("Password must be at least 12 characters long")
    }

    if (errors.length > 0 ) {
        console.error(errors)
        return false
    }

    return true
}

function validateNoEmptyFields() {
    myForm = document.getElementsByTagName('form')[0]
    for (elt in myForm.elements) {
        if (myForm.elements[elt].value == '') {
            console.log(myForm.elements[elt])
            alert('Cannot leave a field blank')
            return false
        }
    }

    return true
}

function passwordsMatch() {
    password = document.getElementById('password').value
    passwordConfirm = document.getElementById('pw-confirm').value
    return password === passwordConfirm
}

function passwordLength() {
    return document.getElementById('password').value.length >= 12
}

function noEmptyInputFields() {
    return false
}

function validateUsername() {
    return false
}

