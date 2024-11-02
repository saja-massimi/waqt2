<script>
function showAddCouponDialog() {
    const today = new Date().toISOString().split('T')[0];

    Swal.fire({
        title: "Add New Coupon",
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
                <label for="couponName">Coupon Name</label>
                <input id="couponName" type="text" class="swal2-input" required>
            </div>
            <div class="input-container">
                <label for="couponValue">Coupon Value</label>
                <input id="couponValue" type="number" class="swal2-input" required min="0" step="0.01">
            </div>
            <div class="input-container">
                <label for="startDate">Start Date</label>
                <input id="startDate" type="date" class="swal2-input" required min="${today}">
            </div>
            <div class="input-container">
                <label for="endDate">End Date</label>
                <input id="endDate" type="date" class="swal2-input" required min="${today}">
            </div>
            <div class="input-container">
                <label for="usageLimit">Usage Limit</label>
                <input id="usageLimit" type="number" class="swal2-input" required min="1">
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        cancelButtonText: "Cancel",
        preConfirm: () => {
            const couponName = document.getElementById('couponName').value;
            const couponValue = document.getElementById('couponValue').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const usageLimit = document.getElementById('usageLimit').value;

            if (!couponName || !couponValue || !startDate || !endDate || !usageLimit) {
                Swal.showValidationMessage("Please fill in all required fields.");
                return false;
            }

            if (isNaN(couponValue) || parseFloat(couponValue) <= 0) {
                Swal.showValidationMessage("Coupon value must be a positive number.");
                return false;
            }

            if (new Date(startDate) > new Date(endDate)) {
                Swal.showValidationMessage("End date must be after start date.");
                return false;
            }

            return {
                coupon_name: couponName,
                coupon_value: parseFloat(couponValue),
                start_date: startDate,
                end_date: endDate,
                usage_limit: parseInt(usageLimit)
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            fetch('./DB/add_coupon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Saved!", "Coupon added successfully!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire("Error!", "Could not add coupon.", "error");
                }
            })
            .catch(err => {
                Swal.fire("Error!", "Could not add coupon.", "error");
            });
        }
    });
}
</script>
