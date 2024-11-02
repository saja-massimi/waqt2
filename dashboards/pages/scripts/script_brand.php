<script>
function brand_add() {
    Swal.fire({
        title: "Add New Brand",
        html: `
            <style>
                .swal2-input {
                    width: 80%;
                    box-sizing: border-box;
                    font-size: 16px;
                }
                .swal2-popup {
                    overflow-y: auto;
                    max-height: 80vh;
                }
                .input-container {
                    margin-bottom: 15px;
                }
                label {
                    display: block;
                    font-size: 18px;
                    margin-bottom: 5px;
                }
            </style>
            <div class="input-container">
                <label for="watchBrand">Brand</label>
                <input id="watchBrand" class="swal2-input" required>
            </div>
            <div class="input-container">
                <label for="watchImage">Image</label>
                <input id="watchImage" type="file" class="swal2-input" accept=".jpg, .jpeg, .png" required>
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        cancelButtonText: "Cancel",
        preConfirm: () => {
            const imageFile = document.getElementById('watchImage').files[0];
            const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const brandName = document.getElementById('watchBrand').value;

            if (!brandName.trim()) {
                Swal.showValidationMessage("Enter the brand name.");
                return false;
            }

            if (!imageFile) {
                Swal.showValidationMessage("Upload an image.");
                return false;
            }

            if (!validImageTypes.includes(imageFile.type)) {
                Swal.showValidationMessage("Invalid image format. Only JPG, JPEG, and PNG are allowed.");
                return false;
            }

            return {
                brand_name: brandName,
                brand_image: imageFile
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            const formData = new FormData();
            formData.append('brand_name', data.brand_name);
            formData.append('brand_image', data.brand_image);

            fetch('./DB/add_brand.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Saved!", "Brand added successfully!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire("Error!", "Could not add brand.", "error");
                }
            })
            .catch(err => {
                Swal.fire("Error!", "Could not add brand.", "error");
            });
        }
    });
}


function brand_delete(brand_id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
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
            xhr.open("POST", "./DB/delete_brand.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    Swal.fire({
                        title: 'Deleted!',
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
                        text: 'An error occurred while deleting the user.',
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
            xhr.send("brand_id=" + encodeURIComponent(brand_id));
        }
    });
}


function brand_Edit(brandId, brandName) {
    Swal.fire({
        title: "Edit Brand",
        html: `
            <style>
                .swal2-input {
                    width: 80%;
                    box-sizing: border-box;
                    font-size: 16px;
                }
                .swal2-popup {
                    overflow-y: auto;
                    max-height: 80vh;
                }
                .input-container {
                    margin-bottom: 15px;
                }
                label {
                    display: block;
                    font-size: 18px;
                    margin-bottom: 5px;
                }
            </style>
            <div class="input-container">
                <label for="editName">Brand Name</label>
                <input id="editName" class="swal2-input" value="${brandName}" required>
            </div>
            <div class="input-container">
                <label for="editImage">Image</label>
                <input id="editImage" type="file" class="swal2-input" accept=".jpg, .jpeg, .png">
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        cancelButtonText: "Cancel",
        preConfirm: () => {
            const imageFile = document.getElementById('editImage').files[0];
            const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            const brandNameInput = document.getElementById('editName').value.trim();

            if (!brandNameInput) {
        Swal.showValidationMessage("Enter a brand name.");
        return false;
    }

    // Check if an image file is uploaded
    if (imageFile && !validImageTypes.includes(imageFile.type)) {
    Swal.showValidationMessage("Invalid image format. Only JPG, JPEG, and PNG are allowed.");
    return false;
}

   

           

            return {
                brand_id: brandId,
                brand_name: brandNameInput,
                brand_image: imageFile || null // Set to null if no new image is uploaded
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            const formData = new FormData();
            formData.append('brand_id', data.brand_id);
            formData.append('brand_name', data.brand_name);
            if (data.brand_image) {
                formData.append('brand_image', data.brand_image);
            }

            fetch('./DB/update_brand.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Saved!", "Brand updated successfully!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire("Error!", "Could not update brand.", "error");
                }
            })
            .catch(err => {
                Swal.fire("Error!", "Could not update brand.", "error");
            });
        }
    });
}



</script>
