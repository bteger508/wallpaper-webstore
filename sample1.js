

function validateNoEmptyFields() {
    alert("hello")
    // Doesn't quite work yet
    myForm = document.getElementsByTagName('form')[0]
    for (elt in myForm.elements) {
        if (myForm.elements[elt].value == '') {
            console.log(myForm.elements[elt])
            alert('Cannot leave a field blank')
            return
        }
    }
}

function passwordsMatch() {
    password = document.getElementById('password').value
    passwordConfirm = document.getElementById('pw-confirm').value
    return password === passwordConfirm
}

function noEmptyInputFields() {
    return false
}

function validateUsername() {
    return false
}

