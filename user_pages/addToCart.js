
function add_cart(product_id) {


    fetch('./controllers/cartController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            product_id: product_id,
            action: 'add'
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {

                Swal.fire({
                    title: "Product added to cart successfully!",
                    icon: "success"
                });


            } else {
                Swal.fire({
                    title: "You need To Login First",
                    icon: "error"
                });
            }
        })
        .catch(error => console.error('Error adding product to cart:', error));

}

function add_cartWithQuantity(product_id) {

    const quantityInput = document.getElementById('quantity-input').value;

    fetch('./controllers/cartController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            product_id: product_id,
            quantity: quantityInput,
            action: 'set'
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {

                Swal.fire({
                    title: "Product added to cart successfully!",
                    icon: "success"
                });


            } else {
                Swal.fire({
                    title: "You need To Login First",
                    icon: "error"
                });
            }
        })
        .catch(error => console.error('Error adding product to cart:', error));
}



function addWishlist(product_id) {
    fetch('controllers/wishlistController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            product_id: product_id,
            action: 'fav'
        })
    })
        .then(response => response.json())
        .then(data => {

            if (data.status === 'success') {
                Swal.fire({
                    title: "Product added to wishlist successfully!",
                    icon: "success"
                });

                const wishlistButton = document.querySelector(`[data-id="${product_id}"] i`);
                wishlistButton.classList.toggle('fas');
                wishlistButton.classList.toggle('far');
            } else {
                Swal.fire({
                    title: "You need To Login First",
                    icon: "error"
                });
            }
        })
        .catch(error => {
            console.error('Error adding product to wishlist:', error)

        });
}
