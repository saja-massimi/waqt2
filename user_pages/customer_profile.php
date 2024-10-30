<?php
session_start();
include('dbconnection.php');
//echo $_SESSION['user'];

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/index.html");
    exit();
}
$updateMessage = ""; 
$updateMessage1 = ""; 

$user_id = $_SESSION['user'];

$query="SELECT user_name, user_email , user_phoneNum, user_password, user_address FROM `users`WHERE `user_id`=:id";


$statement=$dbconnection->prepare($query);
$statement->bindParam(':id',$user_id,PDO::PARAM_INT);
$statement->execute();

$user=$statement->fetch(PDO::FETCH_ASSOC);
//print_r($user);


if(isset($_POST['edit_profile'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobile=$_POST['phone'];
    $address=$_POST['address'];
    $user_id = $_SESSION['user'];


    //echo "$name";

    $query="UPDATE `users` SET `user_email`=:user_email,`user_name`=:user_name,`user_phoneNum`=:user_phoneNum,`user_address`=:user_address WHERE `user_id`=:user_id";
    $statment=$dbconnection->prepare($query);
    $statment->bindParam(':user_name',$name);
    $statment->bindParam(':user_email',$email);
    $statment->bindParam(':user_phoneNum',$mobile);
    $statment->bindParam(':user_address',$address);
    $statment->bindParam(':user_id',$user_id);
    $statment->execute();

    $rowsAffected = $statment->rowCount();

        if ($rowsAffected > 0) {
            $updateMessage = "success";
            echo "
            <script>
            setTimeout(function() {
            window.location.href = 'customer_profile.php';
            }, 2000); 
            </script>
            ";
            } else {
            $updateMessage = "error";
        }

// if($statment->execute()){

//     $updateMessage = "success";
// }else{
//     $updateMessage = "error";
// }

}

if(isset($_POST['edit_password'])){
    $currentPassword=$_POST['old_password'];
    $newPassword=$_POST['new_password'];


 // Verify if the current password matches the one in the database
 if (password_verify($currentPassword, $user['user_password'])) {
    // Hash the new password
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateMessage1 = "password_success";

} else {
    $newHashedPassword = $user['user_password'];
    $updateMessage1 = "password_error";

}

$query = "UPDATE `users` SET `user_password` = :user_password  WHERE `user_id` = :user_id";
$statment = $dbconnection->prepare($query);
$statment->bindParam(':user_password', $newHashedPassword);
$statment->bindParam(':user_id', $user_id);
$statment->execute();


    // if ($statement->execute()) {
    //     $updateMessage1 = "password_success";
    // } else {
    //     $updateMessage1 = "password_error";
    // }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  
  <style>
    /* Reset and basic styling */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Josefin Sans", sans-serif;
    }

    :root {
      --Color1: #16161a;
      --Color2: #ff2020;
      --Color3: #0b1c39;
      --BgColor1: #ffffff;
      --BgColor2: #f0f0f2;
    }

    body {
      background-color: var(--BgColor2);
      color: var(--Color1);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .profile-container {
      background-color: var(--BgColor1);
      border-radius: 15px;
      padding: 40px;
      width: 1000px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
      display: flex;
      gap: 40px; /* Adds space between the columns */
    }

    /* Profile Header (Title + Image) as Column 1 */
    .profile-header {
      flex: 1; /* Set to 1 to allow equal size with other columns */
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
    }

    .profile-header h1 {
      color: var(--Color3);
      font-size: 32px;
      margin-bottom: 20px;
    }

    .profile-header .profile-pic img {
      border-radius: 50%;
      width: 150px;
      height: 150px;
      object-fit: cover;
      border: 4px solid var(--Color2);
    }

    /* Customer Information Section as Column 2 */
    .customer-info {
      flex: 1; /* Set to 1 for equal sizing */
    }

    .customer-info label {
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
      color: var(--Color3);
      font-size: 18px;
    }

    .customer-info input {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      border: 2px solid var(--Color1);
      border-radius: 8px;
      font-size: 18px;
    }

    .button-group {
      display: flex;
      justify-content: flex-end;
      
    }

    .button-group button {
      padding: 15px 30px;
      border: none;
      border-radius: 8px;
      background-color: var(--Color2);
      color: var(--BgColor1);
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .button-group button:hover {
      background-color: var(--Color1);
    }

    /* Password Section */
    .password-section {
      flex: 1; /* Set to 1 for equal sizing */
    }

    .password-section label {
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
      color: var(--Color3);
      font-size: 18px;
    }

    .password-section input {
      width: 100%;
      padding: 15px;
      margin-bottom: 20px;
      border: 2px solid var(--Color1);
      border-radius: 8px;
      font-size: 18px;
    }

    /* Order History Button Styling */
    .order-history {
      display: flex;
      justify-content: center;
    }

    .order-history button {
      padding: 15px 30px;
      border: none;
      border-radius: 8px;
      background-color: var(--Color2);
      color: var(--BgColor1);
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .order-history button:hover {
      background-color: var(--Color1);
    }
  </style>
</head>
<body>

<div class="profile-container">
  <!-- Column 1: Profile Header -->
  <div class="profile-header">
    <h1>Customer Profile</h1>
    <div class="profile-pic">
      <img src="https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=0&k=20&c=yBeyba0hUkh14_jgv1OKqIH0CCSWU_4ckRkAoy2p73o=" alt="Profile Picture">
    </div>
  </div>

  <!-- Column 2: Customer Information -->
  <div class="customer-info">
    <form method="post" action="">
      <label for="name">Name:</label>
      <input type="text" name="name" value="<?php echo $user['user_name'] ?? ''; ?>">

      <label for="email">Email:</label>
      <input type="email" name="email" value="<?php echo $user['user_email'] ?? ''; ?>" class="email">

      <label for="phone">Phone:</label>
      <input type="tel" name="phone" value="<?php echo $user['user_phoneNum'] ?? ''; ?>">

      <label for="address">Address:</label>
      <input type="text" name="address" value="<?php echo $user['user_address'] ?? ''; ?>">

      <!-- Edit Profile Button -->
      <div class="button-group">
        <button name="edit_profile" value="update">Edit Profile</button>
      </div>
    </form>
  </div>

  <!-- Column 3: Password Section -->
  <div class="password-section">
    <form method="post" action="customer_profile.php">
      <label for="old_password">Old Password:</label>
      <input type="password" name="old_password" placeholder="Enter Old Password">

      <label for="new_password">New Password:</label>
      <input type="password" name="new_password" placeholder="Enter New Password">

      <!-- Edit Password Button -->
      <div class="button-group">
        <button type="submit" name="edit_password">Edit Password</button>
      </div>
<br>
      <!-- Order History Button -->
<div class="button-group">
  <button type="button">View Order History</button>
</div>

    </form>
  </div>
</div>

<?php if ($updateMessage == "success"): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Profile updated successfully!',
        timer: 2000,
        showConfirmButton: false
    });
</script>
<?php elseif ($updateMessage == "error"): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Update failed',
        text: 'Please try again.',
        timer: 2000,
        showConfirmButton: false
    });
</script>

<?php elseif ($updateMessage1 == "password_success"): ?>

<script>
    Swal.fire({
        icon: 'success',
        title: 'Password updated successfully!',
        text: 'Redirecting to login...',
        timer: 5000,
        showConfirmButton: false
    }).then(() => {
        window.location.href = '../auth/index.html';
    });
</script>
<?php elseif ($updateMessage1 == "password_error"): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Password update failed',
        text: 'There was an issue updating the password. Please try again.',
    });
</script>

<?php endif; ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>
