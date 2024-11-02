<script>
function showAddDialog() {
    Swal.fire({
        title: "Add New Watch",
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
                <label for="watchName">Watch Name</label>
                <input id="watchName" class="swal2-input" required>
            </div>
            <div class="input-container">
                <label for="watchDescription">Description</label>
                <input id="watchDescription" class="swal2-input">
            </div>
            <div class="input-container">
                <label for="watchPrice">Price</label>
                <input id="watchPrice" type="number" class="swal2-input" required min="0">
            </div>
            <div class="input-container">
                <label for="watchCategory">Category</label>
                <input id="watchCategory" class="swal2-input" required>
            </div>
            <div class="input-container">
                <label for="watchBrand">Brand</label>
                <input id="watchBrand" class="swal2-input" required>
            </div>


             <div class="input-container">
                <label for="watchQuantity">Quantity</label>
                <input id="watchQuantity" class="swal2-input" required>
            </div>
            <div class="input-container">
                <label for="watchModel">Model</label>
                <input id="watchModel" class="swal2-input" required>
            </div>
            <div class="input-container">
                <label for="strapMaterial">Strap Material</label>
                <input id="strapMaterial" class="swal2-input" required>
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
            const watchPrice = document.getElementById('watchPrice').value;
            const watchQuantity = document.getElementById('watchQuantity').value;
            const requiredFields = [
                document.getElementById('watchName').value,
                watchPrice,
                document.getElementById('watchCategory').value,
                document.getElementById('watchBrand').value,
                document.getElementById('watchModel').value,
                document.getElementById('strapMaterial').value
            ];

            if (requiredFields.some(field => field.trim() === "")) {
                Swal.showValidationMessage("Please fill in all required fields.");
                return false;
            }

            if (!imageFile) {
                Swal.showValidationMessage("You must upload a new image.");
                return false;
            }

            if (!validImageTypes.includes(imageFile.type)) {
                Swal.showValidationMessage("Invalid image format. Only JPG, JPEG, and PNG are allowed.");
                return false;
            }

            if (isNaN(watchPrice) || parseFloat(watchPrice) <= 0) {
                Swal.showValidationMessage("Price must be a positive number.");
                return false;
            }



            if (isNaN(watchQuantity) || parseFloat(watchQuantity) <= 1) {
                Swal.showValidationMessage("Quantity must be a positive number.");
                return false;
            }

            return {
                watch_name: document.getElementById('watchName').value,
                watch_price: parseFloat(watchPrice),
                watch_description: document.getElementById('watchDescription').value,
                watch_category: document.getElementById('watchCategory').value,
                watch_brand: document.getElementById('watchBrand').value,
                watchQuantity: document.getElementById('watchQuantity').value,
                watch_model: document.getElementById('watchModel').value,
                strap_material: document.getElementById('strapMaterial').value,
                watch_image: imageFile
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            const formData = new FormData();
            Object.keys(data).forEach(key => {
                formData.append(key, data[key]);
            });

            fetch('./DB/add_product.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Saved!", "Watch added successfully!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire("Error!", "Could not add watch.", "error");
                }
            })
            .catch(err => {
                Swal.fire("Error!", "Could not add watch.", "error");
            });
        }
    });
}
</script>
