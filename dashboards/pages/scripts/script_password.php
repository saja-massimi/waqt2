<script>
function update_password(user_email) {
    const oldPass = document.getElementById("old_pass").value;
    const newPass = document.getElementById("new_pass").value;
    const matchPass = document.getElementById("match_pass").value;

    if (newPass !== matchPass || !oldPass || !newPass) {
       document.getElementById('show_error').innerHTML ="Please ensure all fields are filled and passwords match.";
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./DB/update_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            eval(xhr.responseText);
        }
    };
    xhr.send("user_email=" + encodeURIComponent(user_email) + "&old_pass=" + encodeURIComponent(oldPass) + "&new_pass=" + encodeURIComponent(newPass));
}
</script>
