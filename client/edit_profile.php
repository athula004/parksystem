<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../db.php'; // MongoDB connection

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    echo '<script>alert("Access Denied!"); window.location.href="/parksystem/login.html";</script>';
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing client data
$clientData = $clientsCollection->findOne(["user_id" => new MongoDB\BSON\ObjectId($user_id)]);

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Basic validation
    if (empty($name) || empty($address) || empty($phone)) {
        $error = "Please fill all the required fields.";
    } elseif (!empty($password) && $password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Update client info
        $updateFields = [
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
        ];

        $clientsCollection->updateOne(
            ["user_id" => new MongoDB\BSON\ObjectId($user_id)],
            ['$set' => $updateFields]
        );

        // If password is changed
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $usersCollection->updateOne(
                ["_id" => new MongoDB\BSON\ObjectId($user_id)],
                ['$set' => ['password' => $hashedPassword]]
            );
        }

        echo '<script>alert("Profile updated successfully!"); window.location.href="./clientdashboard.php";</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        form label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #555;
        }
        form input[type="text"], 
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .btn {
            width: 100%;
            padding: 12px;
            background: #333;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #555;
        }
        .error {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
        a.back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #333;
            text-decoration: none;
        }
        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>

    <?php if (isset($error)) { echo "<div class='error'>$error</div>"; } ?>

    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($clientData['name'] ?? '') ?>" required>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="<?= htmlspecialchars($clientData['address'] ?? '') ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($clientData['phone'] ?? '') ?>" required>

        <label for="password">New Password (Leave blank if not changing):</label>
        <input type="password" name="password" id="password">

        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" id="confirm_password">

        <button type="submit" class="btn">Update Profile</button>
    </form>

    <a href="clientdashboard.php" class="back-link">← Back to Dashboard</a>
</div>

</body>
</html>
