<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function deleteOrder(order_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it!',
        showClass: {
            popup: `
                animate__animated
                animate__fadeInUp
                animate__faster
            `
        },
        hideClass: {
            popup: `
                animate__animated
                animate__fadeOutDown
                animate__faster
            `
        }
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./DB/delete_order.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    Swal.fire({
                        title: 'Updated!',
                        text: xhr.responseText, 
                        icon: 'success',
                        showClass: {
                            popup: `
                                animate__animated
                                animate__fadeInUp
                                animate__faster
                            `
                        },
                        hideClass: {
                            popup: `
                                animate__animated
                                animate__fadeOutDown
                                animate__faster
                            `
                        }
                    });

                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else if (xhr.readyState == 4) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the order.',
                        icon: 'error',
                        showClass: {
                            popup: `
                                animate__animated
                                animate__fadeInUp
                                animate__faster
                            `
                        },
                        hideClass: {
                            popup: `
                                animate__animated
                                animate__fadeOutDown
                                animate__faster
                            `
                        }
                    });
                }
            };
            xhr.send("order_id=" + encodeURIComponent(order_id));
        }
    });
}
</script>
