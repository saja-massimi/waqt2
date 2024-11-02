<script>
function confirmDelete(reviewId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the review!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./DB/delete_review.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    Swal.fire(
                        'Deleted!',
                        'Your review has been deleted.',
                        'success'
                    );
                    document.getElementById(reviewId).remove();
                } else if (xhr.readyState == 4) {
                    Swal.fire(
                        'Error!',
                        'There was an error deleting the review.',
                        'error'
                    );
                }
            };
            xhr.send("review_id=" + encodeURIComponent(reviewId));
        }
    });
}
</script>
