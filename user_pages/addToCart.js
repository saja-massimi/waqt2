

function add_cart(product_id) {
    console.log("Button clicked!");
    console.log(product_id);

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
                alert(data.message);
            }
        })
        .catch(error => console.error('Error adding product to cart:', error));

}
