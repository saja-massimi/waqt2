<script>
function showEditOrderDialog(orderId, currentState) {
    let options = '';

    if (currentState === 'pending') {
        options = `
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
        `;
    } else if (currentState === 'shipped') {
        options = `
            <option value="delivered">Delivered</option>
        `;
    } else {
        options = `
            <option value="pending">Pending</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
        `;
    }

    Swal.fire({
        title: "Edit Order State",
        html: `
            <div class="input-container">
                <label for="orderState">Select New State</label>
                <select id="orderState" class="swal2-input">
                    ${options}
                </select>
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        cancelButtonText: "Cancel",
        preConfirm: () => {
            const newState = document.getElementById('orderState').value;
            return {
                order_id: orderId,
                order_status: newState
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            fetch('./DB/update_order.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Saved!", "Order state updated successfully!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire("Error!", data.message, "error");
                }
            })
            .catch(err => {
                Swal.fire("Error!", "Could not update order.", "error");
            });
        }
    });
}
</script>
