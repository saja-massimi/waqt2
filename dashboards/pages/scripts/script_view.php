<script>
    function viewOrder(orderId) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "./DB/get_order_details.php?order_id=" + encodeURIComponent(orderId), true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var orderDetails = JSON.parse(xhr.responseText);
                var detailsHtml = "<h5>Order Address: " + orderDetails.order_address + "</h5>";
                detailsHtml += "<h5>Order Date: " + orderDetails.order_date + "</h5>";
                detailsHtml += "<table class='table'><tr><th>Watch Name</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
                
                var grandTotal = 0;
                
                orderDetails.items.forEach(item => {
                    var total = item.price * item.quantity;
                    grandTotal += total;
                    detailsHtml += "<tr><td>" + item.watch_name + "</td><td>" + item.quantity + "</td><td>" + item.price + "</td><td>" + total + "</td></tr>";
                });
                
                detailsHtml += "<tr><td colspan='3' style='text-align:right;'><strong>Total:</strong></td><td><strong>" + grandTotal + "</strong></td></tr>";
                detailsHtml += "</table>";

                Swal.fire({
                    title: 'Order Details',
                    html: detailsHtml,
                    showCloseButton: true,
                    focusConfirm: false,
                });
            }
        };
        xhr.send();
    }
</script>
