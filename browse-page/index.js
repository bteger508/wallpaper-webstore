// ====== ADD ACTIVE ROUTE LINK ==========
function addActiveRoute() {
	let element = document.getElementById('browse_route')
	element.classList.add('active')
}
$(document).ready(function () {
	addActiveRoute()
})

function getProductsByTag() {
	let tag = document.getElementById('tag-select').value
	let url = `./?tag=${tag}`
	window.location.href = url
}
