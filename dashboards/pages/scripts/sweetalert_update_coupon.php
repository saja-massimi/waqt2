<script>
function showEditCouponDialog(couponId, couponValue, startDate, endDate, usageLimit) {
    const today = new Date().toISOString().split('T')[0];
    const startDateValue = new Date(startDate).toISOString().split('T')[0];
    const isStartDateEditable = startDateValue > today;

    Swal.fire({
        title: "Edit Coupon",
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
                <label for="couponValue">Coupon Value</label>
                <input id="couponValue" class="swal2-input" type="number" value="${couponValue}" required min="0" step="0.01">
            </div>
            <div class="input-container">
                <label for="startDate">Start Date</label>
                <input id="startDate" class="swal2-input" type="date" value="${startDateValue}" ${isStartDateEditable ? '' : 'disabled'}>
            </div>
            <div class="input-container">
                <label for="endDate">End Date</label>
                <input id="endDate" class="swal2-input" type="date" value="${endDate}" required min="${startDateValue}">
            </div>
            <div class="input-container">
                <label for="usageLimit">Usage Limit</label>
                <input id="usageLimit" class="swal2-input" type="number" value="${usageLimit}" required min="0">
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        cancelButtonText: "Cancel",
        preConfirm: () => {
            
            const couponValue = document.getElementById('couponValue').value;
            const startDateInput = document.getElementById('startDate').value;
            const endDateInput = document.getElementById('endDate').value;
            const usageLimitInput = document.getElementById('usageLimit').value;

            if (!couponValue || !endDateInput || !usageLimitInput) {
                Swal.showValidationMessage("Please fill in all required fields.");
                return false;
            }

            if (new Date(endDateInput) < new Date(startDateValue)) {
                Swal.showValidationMessage("End date must be after start date.");
                return false;
            }

            return {
                coupon_id: couponId,
                coupon_value: parseFloat(couponValue),
                end_date: endDateInput,
                start_date: isStartDateEditable ? startDateInput : startDateValue,
                usage_limit: parseInt(usageLimitInput, 10)
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            fetch('./DB/update_coupon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Saved!", "Coupon updated successfully!", "success");
                    setTimeout(() => {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire("Error!", data.message, "error");
                }
            })
            .catch(err => {
                Swal.fire("Error!", "Could not update coupon.", "error");
            });
        }
    });
}
</script>
