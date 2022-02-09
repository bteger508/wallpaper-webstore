const errors = []
document.getElementById('registerForm').addEventListener('submit', validateAll)

function validateAll(event) {
	if (!checkSpecialCharacters(getPassword())) {
		errors.push('Passwords must contain at least 2 special characters')
	}
	if (!contains2Numbers(getPassword())) {
		errors.push('Passwords must contain at least 2 numbers')
	}
	if (!passwordsMatch(getPassword(), getPasswordConfirm())) {
		errors.push('Passwords must match')
	}
	if (!passwordLength(getPassword())) {
		errors.push('Password must be at least 12 characters long')
	}

	if (!checkUsername(getUsername())) {
		errors.push(
			'Username must be at least 8 characters long with only numbers and letters'
		)
	}

	document.getElementById('registerErrors').innerHTML = ''
	if (errors.length > 0) {
		console.error(errors)
		for (err of errors) {
			document.getElementById('registerErrors').innerHTML +=
				'<p>' + err + '</p>'
		}
		while (errors.length > 0) {
			errors.pop()
		}
		event.preventDefault()
		return false
	}

	return true
}

// Passwords: 12 chars (2 digits, 2 special)
function contains2Numbers(pw) {
	let containsNums = /.*(\d).*(\d)/
	return containsNums.test(pw)
}

function passwordsMatch(pw1, pw2) {
	return pw1 === pw2
}

function passwordLength(pw) {
	return pw.length >= 12
}

function checkSpecialCharacters(pw) {
	try {
		let reSpecial = /([!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?])/
		console.log(reSpecial.exec(pw))

		// .exec returns null if there are no matches
		return reSpecial.exec(pw).length >= 2
	} catch (error) {
		return false
	}
}

function checkUsername(username) {
	let valid = /([a-zA-Z0-9]){8,}/
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
