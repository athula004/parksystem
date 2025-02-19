<?php
require '../db.php'; // MongoDB connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = "staff"; // Role is predefined

    $name = $_POST["name"];
    $age = $_POST["age"];
    $address = $_POST["address"];

    // Handle file upload
    $photoPath = "";
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $photoDir = "uploads/staffimag/";
        $photoName = time() . "_" . basename($_FILES["photo"]["name"]);
        $photoPath = $photoDir . $photoName;
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath);
    }

    // Insert into users collection
    $userInsertResult = $usersCollection->insertOne([
        "email" => $email,
        "password" => $password,
        "role" => $role
    ]);

    if ($userInsertResult->getInsertedCount() > 0) {
        $userId = $userInsertResult->getInsertedId(); // Get the user ID

        // Insert into staff collection
        $staffInsertResult = $staffCollection->insertOne([
            "user_id" => $userId,
            "name" => $name,
            "age" => $age,
            "address" => $address,
            "photo" => $photoPath
        ]);

        if ($staffInsertResult->getInsertedCount() > 0) {
            echo '<script>alert("Staff Registered Successfully!"); window.location.href="../admin_dashboard.php";</script>';
        } else {
            echo '<script>alert("Error storing staff details!");</script>';
        }
    } else {
        echo '<script>alert("Error registering user!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
        }
        input {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: black;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register Staff</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="number" name="age" placeholder="Age" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="file" name="photo" accept="image/*" required>
            <button type="submit">Register Staff</button>
        </form>
    </div>
</body>
</html>
