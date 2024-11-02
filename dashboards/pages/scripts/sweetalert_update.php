<script>
function showEditDialog(watchId, name, description, price, category, brand, model, strapMaterial,url,quantity) {
    Swal.fire({
        title: "Edit Watch",
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
                <input id="watchName" class="swal2-input" value="${name}" required>
            </div>
            <div class="input-container">
                <label for="watchDescription">Description</label>
                <input id="watchDescription" class="swal2-input" value="${description}">
            </div>
            <div class="input-container">
                <label for="watchPrice">Price</label>
                <input id="watchPrice" class="swal2-input" value="${price}">
            </div>
            <div class="input-container">
                <label for="watchCategory">Category</label>
                <input id="watchCategory" class="swal2-input" value="${category}">
            </div>

            <div class="input-container">
                <label for="watchQuantity">Quantity</label>
                <input id="watchQuantity" class="swal2-input" value="${quantity}">
            </div>
            
            <div class="input-container">
                <label for="watchBrand">Brand</label>
                <input id="watchBrand" class="swal2-input" value="${brand}">
            </div>
            <div class="input-container">
                <label for="watchModel">Model</label>
                <input id="watchModel" class="swal2-input" value="${model}">
            </div>
            <div class="input-container">
                <label for="strapMaterial">Strap Material</label>
                <input id="strapMaterial" class="swal2-input" value="${strapMaterial}">
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
            const requiredFields = [
                document.getElementById('watchName').value,
                document.getElementById('watchPrice').value,
                document.getElementById('watchCategory').value,
                document.getElementById('watchBrand').value,
                document.getElementById('watchQuantity').value,
                document.getElementById('watchModel').value,
                document.getElementById('strapMaterial').value
            ];

            if (requiredFields.some(field => field.trim() === "")) {
                Swal.showValidationMessage("Please fill in all required fields.");
                return false;
            }

            if (imageFile && !validImageTypes.includes(imageFile.type)) {
    Swal.showValidationMessage("Invalid image format. Only JPG, JPEG, and PNG are allowed.");
    return false;
}

            return {
                watch_id: watchId,
                watch_name: document.getElementById('watchName').value,
                watch_price: document.getElementById('watchPrice').value,
                watch_description: document.getElementById('watchDescription').value,
                watch_category: document.getElementById('watchCategory').value,
                watch_brand: document.getElementById('watchBrand').value,
                watch_quantity: document.getElementById('watchQuantity').value,
                watch_model: document.getElementById('watchModel').value,
                strap_material: document.getElementById('strapMaterial').value,
                watch_image: imageFile
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            console.log(data);
            const formData = new FormData();
            Object.keys(data).forEach(key => {
                formData.append(key, data[key]);
            });
            console.log([...formData.entries()]);
            fetch('./DB/update_products.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Saved!", "Watch updated successfully!", "success");
                    console.log(data);
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire("Error!", "Could not update watch.", "error");
                }
            })
            .catch(err => {
                Swal.fire("Error!", "Could not update watch.", "error");
            });
        }
    });
}
</script>
