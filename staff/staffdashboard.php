<?php
require '../db.php'; // MongoDB connection
session_start();

// Check if the user is logged in and has a "staff" role
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] !== "staff") {
    echo '<script>alert("Access Denied! Only staff members can access this page."); window.location.href="../login.php";</script>';
    exit();
}

// Get logged-in staff's email from the session
$staffEmail = $_SESSION["user"]["email"];

// Find user details in the users collection
$user = $usersCollection->findOne(["email" => $staffEmail]);

if (!$user) {
    echo '<script>alert("User not found!"); window.location.href="../login.php";</script>';
    exit();
}

// Find staff details using user ID
$staff = $staffCollection->findOne(["user_id" => $user["_id"]]);

if (!$staff) {
    echo '<script>alert("Staff details not found!"); window.location.href="../login.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 50%;
            max-width: 400px;
        }
        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            margin: 5px 0;
        }
        button {
            background: black;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        button:hover {
            background: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($staff["name"]); ?>!</h2>
    <img src="<?php echo $staff["photo"]; ?>" alt="Staff Photo">
    <p><strong>Email:</strong> <?php echo htmlspecialchars($staffEmail); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($staff["age"]); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($staff["address"]); ?></p>
    <button onclick="window.location.href='../logout.php'">Logout</button>
</div>

</body>
</html>
