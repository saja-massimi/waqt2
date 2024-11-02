<!DOCTYPE html>
<html lang="en">
<?php include("../widgets/navbar.php"); ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="../css/style.css" rel="stylesheet">

    <style>
        :root {
            --mainColor: #4A55A2;
            --secondColor: #A0BFE0;
            --whiteColor: #ffffff;
            --titleColor: #555555;
            --labelColor: #333333;
            --Color1: #16161a;
            --Color2: #ff2020;
            --Color3: #0b1c39;
            --BgColor1: #ffffff;
            --BgColor2: #f0f0f2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }


        body {
            background-color: var(--BgColor2);
            display: grid;
            min-height: 100vh;

        }

        .profile-container {
            width: 80%;
            background-color: var(--BgColor1);
            color: var(--labelColor);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: auto;



        }

        .profile-header {
            background: linear-gradient(120deg, var(--Color2), var(--Color3));
            color: var(--whiteColor);
            text-align: center;
            padding: 20px;
        }

        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid var(--Color3);
        }

        .profile-header h2 {
            color: var(--whiteColor);
            margin-top: 10px;
        }

        .nav-tabs {
            display: flex;
            justify-content: space-around;
            background-color: var(--BgColor1);
            border-bottom: 1px solid var(--Color3);
        }

        .nav-tabs a {
            flex: 1;
            text-align: center;
            padding: 15px;
            cursor: pointer;
            text-decoration: none;
            color: var(--titleColor);
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .nav-tabs a.active {
            background-color: #ededef;
            color: var(--Color3);
            font-weight: bold;
            box-shadow: 10px;

        }

        .tab-content {
            padding: 20px;
            background-color: var(--BgColor1);
            color: var(--labelColor);
        }

        .tab-content h3 {
            margin-bottom: 15px;
        }

        .tab-content label {
            display: block;
            margin: 10px 0 5px;
            color: var(--titleColor);
        }

        .tab-content input,
        .tab-content textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--labelColor);
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .tab-content button {
            background: linear-gradient(120deg, var(--Color2), var(--Color3));
            color: var(--whiteColor);
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .tab-content button:hover {
            background-color: var(--Color3);
        }

        .order-history table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .order-history th,
        .order-history td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid var(--BgColor2);
        }

        .order-history th {
            background-color: var(--BgColor1);
            color: var(--Color1);
        }
    </style>

</head>

<body>

    <?php
    require_once('models/Dbh.php');
    require_once('models/orderModel.php');
    include('dbconnection.php');

    $orders = new orderModel();
    $user_id = $_SESSION['user'];


    if (!isset($_SESSION['user'])) {
        print_r($user_id);

        exit();
    }
    $updateMessage = "";
    $updateMessage1 = "";
    $newHashedPassword = "";


    $query = "SELECT user_name, user_email , user_phoneNum, user_password,user_country, user_city, user_street  FROM `users`WHERE `user_id`=:id";


    $statement = $dbconnection->prepare($query);
    $statement->bindParam(':id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if (isset($_POST['edit_profile'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['phone'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $street = $_POST['street'];
        $user_id = $_SESSION['user'];


        $query = "UPDATE `users` SET `user_email`=:user_email,`user_name`=:user_name,`user_phoneNum`=:user_phoneNum, `user_country`=:user_country, `user_city`=:user_city, `user_street`=:user_street WHERE `user_id`=:user_id";
        $statment = $dbconnection->prepare($query);
        $statment->bindParam(':user_name', $name);
        $statment->bindParam(':user_email', $email);
        $statment->bindParam(':user_phoneNum', $mobile);
        $statment->bindParam(':user_country', $country);
        $statment->bindParam(':user_city', $city);
        $statment->bindParam(':user_street', $street);
        $statment->bindParam(':user_id', $user_id);
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
    }

    if (isset($_POST['edit_password'])) {
        $currentPassword = $_POST['old_password'];
        $newPassword = $_POST['new_password'];

        // Validate password
        if (strlen($newPassword) < 8) {
            $validationMessage = "Password must be at least 8 characters long";
        } elseif (!preg_match('/[A-Z]/', $newPassword)) {
            $validationMessage = "Password must contain at least one uppercase letter";
        } elseif (!preg_match('/[a-z]/', $newPassword)) {
            $validationMessage = "Password must contain at least one lowercase letter";
        } elseif (!preg_match('/[0-9]/', $newPassword)) {
            $validationMessage = "Password must contain at least one number";
        } elseif (!preg_match('/[!@#$%^&*]/', $newPassword)) {
            $validationMessage = "Password must contain at least one special character";
        } elseif (strpos($newPassword, ' ') !== false) {
            $validationMessage = "Password cannot contain spaces";
        } elseif (strlen($newPassword) > 20) {
            $validationMessage = "Password cannot be more than 20 characters long";
        } elseif (!preg_match('/^[a-zA-Z0-9!@#$%^&*]+$/', $newPassword)) {
            $validationMessage = "Password contains invalid characters";
        }

        if (empty($validationMessage)) {

            // Verify if the current password matches the one in the database
            password_verify($currentPassword, $user['user_password']);
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
    }
    ?>



    <div class="profile-container">
        <div class="profile-header">
            <img src="https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg?s=612x612&w=0&k=20&c=yBeyba0hUkh14_jgv1OKqIH0CCSWU_4ckRkAoy2p73o=" alt="Profile Picture">
            <h2><?php echo $user['user_name'] ?? ''; ?></h2>
        </div>

        <div class="nav-tabs">
            <a href="#" data-tab="profile" onclick="openTab('profile')">Edit Profile</a>
            <a href="#" data-tab="password" onclick="openTab('password')">Edit Password</a>
            <a href="#" data-tab="history" onclick="openTab('history')">Order History</a>
        </div>

        <div id="profile" class="tab-content">
            <h3>Edit Profile</h3>
            <form method="post" action="">
                <label for="name">Name:</label>
                <input class="form-control" type="text" name="name" value="<?php echo $user['user_name'] ?? ''; ?>">

                <label for="email">Email:</label>
                <input class="form-control" type="email" name="email" value="<?php echo $user['user_email'] ?? ''; ?>" class="email">

                <label for="phone">Phone:</label>
                <input class="form-control" type="tel" name="phone" value="<?php echo $user['user_phoneNum'] ?? ''; ?>">

                <label for="country">Country:</label>
                <input class="form-control" type="text" name="country" value="<?php echo $user['user_country'] ?? ''; ?>">


                <label for="street">Street:</label>
                <input class="form-control" type="text" name="street" value="<?php echo $user['user_street'] ?? ''; ?>">

                <label for="city">City:</label>
                <select class="custom-select form-control" name="city">
                    <option value="irbid" <?php echo ($user['user_city'] ?? '') === 'irbid' ? 'selected' : ''; ?>>Irbid</option>
                    <option value="jarash" <?php echo ($user['user_city'] ?? '') === 'jarash' ? 'selected' : ''; ?>>Jarash</option>
                    <option value="ajloun" <?php echo ($user['user_city'] ?? '') === 'ajloun' ? 'selected' : ''; ?>>Ajloun</option>
                    <option value="aqaba" <?php echo ($user['user_city'] ?? '') === 'aqaba' ? 'selected' : ''; ?>>al-'Aqaba</option>
                    <option value="madaba" <?php echo ($user['user_city'] ?? '') === 'madaba' ? 'selected' : ''; ?>>Madaba</option>
                    <option value="mafraq" <?php echo ($user['user_city'] ?? '') === 'mafraq' ? 'selected' : ''; ?>>al-Mafraq</option>
                    <option value="zarqa" <?php echo ($user['user_city'] ?? '') === 'zarqa' ? 'selected' : ''; ?>>al-Zarqa</option>
                    <option value="amman" <?php echo ($user['user_city'] ?? '') === 'amman' ? 'selected' : ''; ?>>Amman</option>
                    <option value="balqa" <?php echo ($user['user_city'] ?? '') === 'balqa' ? 'selected' : ''; ?>>al-Balqa</option>
                    <option value="karak" <?php echo ($user['user_city'] ?? '') === 'karak' ? 'selected' : ''; ?>>al-Karak</option>
                    <option value="tafileh" <?php echo ($user['user_city'] ?? '') === 'tafileh' ? 'selected' : ''; ?>>al-Tafilah</option>
                    <option value="maan" <?php echo ($user['user_city'] ?? '') === 'maan' ? 'selected' : ''; ?>>Ma'an</option>
                </select>


                <!-- Edit Profile Button -->
                <div class="button-group mt-3">
                    <button name="edit_profile" value="update">Edit Profile</button>
                </div>
            </form>
        </div>


        <div id="password" class="tab-content" style="display: none;">
            <h3>Edit Password</h3>
            <form method="post" action="customer_profile.php">
                <label for="old_password">Old Password:</label>
                <input class="form-control" type="password" name="old_password" placeholder="Enter Old Password">

                <label for="new_password">New Password:</label>
                <input class="form-control" type="password" name="new_password" placeholder="Enter New Password">

                <!-- Edit Password Button -->
                <div class="button-group">
                    <button type="submit" name="edit_password">Edit Password</button>
                </div>
            </form>
        </div>

        <div id="history" class="tab-content" style="display: none;">
            <h3>Order History</h3>
            <div class="order-history">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders->getOrders($user_id) as $order) : ?>

                            <tr>
                                <td><?= $order['order_id'] ?></td>
                                <td><?= date("Y-m-d", strtotime($order['created_at'])) ?></td>
                                <td><?= $order['order_total'] ?> JOD</td>
                                <td><?= $order['order_status'] ?></td>
                            </tr>


                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if (!empty($validationMessage)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: '<?php echo $validationMessage; ?>',
                timer: 4000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>


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



    <?php require_once("../widgets/footer.php"); ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTables for the Order History table
        const orderHistoryTable = document.querySelector('#history table');

        if (orderHistoryTable) {
            new DataTable(orderHistoryTable, {
                // Optional DataTables settings
                autoWidth: false,
                paging: true,
                searching: true,
                order: [[1, 'desc']], // Order by Date, descending
                columnDefs: [{
                    targets: "_all",
                    defaultContent: "-"
                }]
            });
        }
    });
</script>

    <script>
        function openTab(tabName) {
            const tabs = document.querySelectorAll(".tab-content");
            tabs.forEach(tab => tab.style.display = "none");
            document.getElementById(tabName).style.display = "block";

            const tabLinks = document.querySelectorAll(".nav-tabs a");
            tabLinks.forEach(link => link.classList.remove("active"));
            document.querySelector(`[data-tab="${tabName}"]`).classList.add("active");

            // Re-initialize DataTables when Order History tab is selected
            if (tabName === 'history') {
                $(document).ready(function() {
                    $('#history table').DataTable();
                });
            }
        }

        window.onload = function() {
            openTab("profile");
        };
    </script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css">
<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>