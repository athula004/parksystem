<?php
require '../db.php'; // MongoDB connection


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $industryName = $_POST["industry_name"];
    $landArea = $_POST["land_area"];
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $description = $_POST["description"];
    $status = "inactive"; // Default status
    $approvel_status = "pending"; // Default status
    $created_at = date("Y-m-d H:i:s");
    $updated_at = date("Y-m-d H:i:s");
    

    // Check if email already exists
    $existingUser = $usersCollection->findOne(["email" => $email]);
    if ($existingUser) {
        echo '<script>alert("Email already exists! Please use a different email.");</script>';
    } else {
        // Handle logo upload
        $logoDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "logos" . DIRECTORY_SEPARATOR;
        if (!is_dir($logoDir)) {
            mkdir($logoDir, 0777, true);
        }
        $logoName = time() . "_" . basename($_FILES["logo"]["name"]);
        $logoPath = $logoDir . $logoName;
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $logoPath)) {
            $logoPath = "uploads/logos/" . $logoName;
        } else {
            echo '<script>alert("Failed to upload logo!");</script>';
            exit;
        }

        // Handle certificate upload
        $certificateDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "certificates" . DIRECTORY_SEPARATOR;
        if (!is_dir($certificateDir)) {
            mkdir($certificateDir, 0777, true);
        }
        $certificateName = time() . "_" . basename($_FILES["certificate"]["name"]);
        $certificatePath = $certificateDir . $certificateName;
        if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $certificatePath)) {
            $certificatePath = "uploads/certificates/" . $certificateName;
        } else {
            echo '<script>alert("Failed to upload certificate!");</script>';
            exit;
        }

        // Insert into users collection
        $userInsertResult = $usersCollection->insertOne([
            "email" => $email,
            "password" => $password,
            "role" => "industry",
            "status" => $status
        ]);

        if ($userInsertResult->getInsertedCount() > 0) {
            $userId = $userInsertResult->getInsertedId();

            // Insert into industries collection
            $industryInsertResult = $industriesCollection->insertOne([
                "user_id" => $userId,
                "industry_name" => $industryName,
                "land_area" => $landArea,
                "contact" => $contact,
                "address" => $address,
                "description" => $description,
                "logo" => $logoPath,
                "certificate" => $certificatePath,
                "created_at" => $created_at, 
                "updated_at" => $updated_at
            ]);

            if ($industryInsertResult->getInsertedCount() > 0) {
                echo '<script>alert("Industry Registered Successfully!!! and Waite For Approval to Login"); window.location.href="../home.php";</script>';
            } else {
                echo '<script>alert("Error storing industry details!");</script>';
            }
        } else {
            echo '<script>alert("Error registering user!");</script>';
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industry Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Align items to the top */
            padding: 20px;
            margin: 0; /* Remove default margin */
            min-height: 100vh; /* Ensure the body takes at least full height */
        }
        form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Maximum width for larger screens */
            box-sizing: border-box; /* Include padding in width calculation */
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            margin-top: 10px;
            font-weight: 500;
            color: #555;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
            box-sizing: border-box; /* Include padding in width calculation */
        }
        input:focus, textarea:focus {
            border-color: #007BFF;
            outline: none;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: -8px;
            margin-bottom: 10px;
        }
        button {
            background-color:rgb(8, 8, 8);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color:rgb(255, 255, 255);
            color: black;
            border: 1px solid black;
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            form {
                padding: 20px; /* Reduce padding on smaller screens */
            }
            h2 {
                font-size: 1.5rem; /* Adjust heading size */
            }
            input, textarea {
                padding: 10px; /* Adjust padding for inputs */
            }
            button {
                padding: 10px; /* Adjust button padding */
            }
        }
    </style>
</head>
<body>

<form id="registrationForm" method="POST" enctype="multipart/form-data">
    <h2>Industry Registration</h2>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <span id="passwordError" class="error"></span>

    <label for="industry_name">Industry Name:</label>
    <input type="text" id="industry_name" name="industry_name" required>

    <label for="land_area">Land Area Required (in sq ft):</label>
    <input type="number" id="land_area" name="land_area" required>

    <label for="contact">Contact Number:</label>
    <input type="tel" id="contact" name="contact" required>

    <label for="address">Address:</label>
    <textarea id="address" name="address" required></textarea>

    <label for="description">Industry Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="logo">Upload Logo:</label>
    <input type="file" id="logo" name="logo" accept=".jpg,.jpeg,.png" required>

    <label for="certificate">Upload Industry Certificate:</label>
    <input type="file" id="certificate" name="certificate" accept=".pdf,.doc,.docx" required>

    <button type="submit">Register</button>
</form>

<script>
    const form = document.getElementById('registrationForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const passwordError = document.getElementById('passwordError');

    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            passwordError.textContent = 'Passwords do not match.';
            return false;
        } else {
            passwordError.textContent = '';
            return true;
        }
    }

    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);

    form.addEventListener('submit', function(event) {
        if (!validatePassword()) {
            event.preventDefault();
        }
    });
</script>

</body>
</html>