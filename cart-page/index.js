// ====== ADD ACTIVE ROUTE LINK ==========
function addActiveRoute() {
	let element = document.getElementById('cart_route');
	element.classList.add('active')
}
$(document).ready(function () {
	addActiveRoute()
})

// // append a product to the cart in the database
// function appendProductToCart(product_id, quantity) {
// 	let data = {
// 		product_id: product_id,
// 		quantity: quantity
// 	}
// 	$.ajax({
// 		url: '/cart/append',
// 		type: 'POST',
// 		data: data,
// 		success: function (response) {
// 			if (response.success) {
// 				console.log('success')
// 			}
// 		}
// 	})
// }