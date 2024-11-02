<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function deleteRecord(userEmail) {
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
                // Proceed with AJAX request if the user confirms
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "./DB/delete_user.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Use SweetAlert to show success message with animations
                        document.getElementById(userEmail).remove();
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
                xhr.send("user_email=" + encodeURIComponent(userEmail));
            }
        });
    }


    function UpdateRecord(userPhoneNum,userAddress,userEmail) {
    Swal.fire({
        title: 'Update User Information',
        html: `
            <input style="width:50%;margin-bottom:20px;" id="phoneNum"  placeholder="Phone Number" value="${userPhoneNum}">
            <br>
            <select style="width:50%;" id="governorate" >
                <option hidden value="ss">Select Governorate</option>
                <option value="Amman">Amman</option>
                <option value="Zarqa">Zarqa</option>
                <option value="Irbid">Irbid</option>
                <option value="Ajloun">Ajloun</option>
                <option value="Mafraq">Mafraq</option>
                <option value="Karak">Karak</option>
                <option value="Tafilah">Tafilah</option>
                <option value="Maan">Maan</option>
                <option value="Aqaba">Aqaba</option>
            </select>
        `,
        didOpen: () => {
            document.getElementById('governorate').value = userAddress || "ss";
        },
        focusConfirm: false,
        preConfirm: () => {
            const phoneNum = document.getElementById('phoneNum').value;
            const governorate = document.getElementById('governorate').value;

            if (!phoneNum || !governorate) {
                Swal.showValidationMessage('Please fill in all fields');
            }

            return { phoneNum, governorate };
        },
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update'
    }).then((result) => {
        if (result.isConfirmed) {
            const { phoneNum, governorate } = result.value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./DB/update_user.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    Swal.fire({
                        title: 'Updated!',
                        text: xhr.responseText,
                        icon: 'success',
                        showClass: {
                            popup: 'animate__animated animate__fadeInUp animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutDown animate__faster'
                        }
                    });

                    setTimeout(function() {
        location.reload();
    }, 2000);
                } else if (xhr.readyState == 4) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while updating the user.',
                        icon: 'error',
                        showClass: {
                            popup: 'animate__animated animate__fadeInUp animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutDown animate__faster'
                        }
                    });
                }
            };
            xhr.send(`phone_num=${encodeURIComponent(phoneNum)}&governorate=${encodeURIComponent(governorate)}&email=${encodeURIComponent(userEmail)}`);
        }
    });
}



function handleRoleChange(checkbox,email) {
    const isChecked = checkbox.checked;



    Swal.fire({
        title: 'Are you sure?',
        text: isChecked ? "Enable this role?" : "Disable this role?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Continue',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX request to update_role.php
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./DB/update_role.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log(xhr.response);
                    
                    Swal.fire({
                        title: 'Updated!',
                        text: xhr.responseText,
                        icon: 'success',
                        showClass: {
                            popup: 'animate__animated animate__fadeInUp animate__faster'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutDown animate__faster'
                        }
                    });
                    if (xhr.response == "Role updated successfully.") {

    setTimeout(function() {
        location.reload();
    }, 2000);
}

                }
            };

            // Send the checkbox status to update_role.php
            xhr.send("role_status=" + (isChecked ? 'admin' : 'customer') + "&email=" + email);

        } else {
            // Revert checkbox state if Cancel is clicked
            checkbox.checked = !isChecked;
        }
    });
}


</script>