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

// make a get request to get products by tag
// function getProductsByTag(tag) {
// 	let url = `/api/products/tag/${tag}`
// 	$.get(url, function (data) {
// 		let products = data.products
// 		let products_html = ''
// 		for (let i = 0; i < products.length; i++) {
// 			products_html += `
// 				<div class="col-md-4 col-sm-6">
// 					<div class="product-item">
// 						<div class="pi-pic">
// 							<img src="${products[i].image}" alt="">
// 							<div class="pi-links">
// 								<a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
// 								<a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
// 							</div>
// 						</div>
// 						<div class="pi-text">
// 							<h6>$${products[i].price}</h6>
// 							<p>${products[i].name}</p>
// 						</div>
// 					</div>
// 				</div>
// 			`
// 		}
// 		$('#products_row').html(products_html)
// 	})
// }
