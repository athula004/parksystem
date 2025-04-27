<?php
session_start(); // Start the session to access $_SESSION variables
error_reporting(E_ALL); // Enable error reporting
ini_set('display_errors', 1); // Display errors on the screen

function checkRole($allowedRoles) {
    if (!isset($_SESSION["role"]) || !in_array($_SESSION["role"], $allowedRoles)) {
        echo '<script>alert("Access Denied!!.."); window.location.href="/parksystem/login.html";</script>';
        exit();
    }
}

require '../db.php'; // MongoDB connection
checkRole(["client"]); // Ensure the logged-in user is a client

// Fetch the logged-in user's ID from the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Initialize client details with default values
$clientName = 'N/A';
$clientEmail = 'N/A';
$clientPhone = 'N/A';
$clientAddress = 'N/A';

// Initialize cart and order counts
$cartItemsCount = 0;
$ordersCount = 0;

try {
    if ($user_id) {
        // Fetch the user data from the 'users' collection
        $userData = $usersCollection->findOne(["_id" => new MongoDB\BSON\ObjectId($user_id)]);
        
        if ($userData) {
            // Fetch the client data from the 'client' collection
            $clientData = $clientsCollection->findOne(["user_id" => new MongoDB\BSON\ObjectId($user_id)]);
            
            if ($clientData) {
                // Update client details if data exists
                $clientName = $clientData['name'] ?? 'N/A';
                $clientEmail = $clientData['email'] ?? 'N/A';
                $clientPhone = $clientData['phone'] ?? 'N/A';
                $clientAddress = $clientData['address'] ?? 'N/A';
            }

            // Fetch cart items count (assuming 'cart' collection)
            // $cartItemsCount = $cartCollection->countDocuments(["user_id" => new MongoDB\BSON\ObjectId($user_id)]);

            // // Fetch orders count (assuming 'orders' collection)
            // $ordersCount = $ordersCollection->countDocuments(["user_id" => new MongoDB\BSON\ObjectId($user_id)]);
        }
    }
} catch (MongoDB\Driver\Exception\Exception $e) {
    // Handle MongoDB exceptions
    die("Error accessing database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            padding: 50px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            justify-items: center; 
            gap: 10px;
            margin-left: 280px; 
        }

        .box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .box:hover {
            background: #ddd;
            transform: scale(1.05);
        }

        .sidebar { 
            width: 250px; 
            background: #333; 
            color: white; 
            padding: 20px; 
            height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0; 
            text-align: center; 
        }

        .header {
            color: black;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-left: 280px;
        }

        .user-info {
    background: linear-gradient(to right, #ffffff, #f9f9f9);
    padding: 30px;
    border-radius: 15px;
    margin: 30px 50px 20px 280px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.user-info:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.user-info h3 {
    font-size: 26px;
    color: #333;
    margin-bottom: 20px;
    border-bottom: 2px solid #ccc;
    padding-bottom: 10px;
}

.user-info p {
    margin: 10px 0;
    font-size: 18px;
    color: #555;
    line-height: 1.6;
}

.user-info p strong {
    color: #000;
}


        .count-box { 
            background: white; 
            color: black; 
            padding: 10px; 
            border-radius: 8px; 
            font-size: 15px; 
            font-weight: bold; 
            margin-top: 20px; 
            animation: fadeIn 1s ease-in-out; 
            cursor: pointer;
        }

        .count-box1 { 
            background: rgb(221, 42, 42); 
            color: white; 
            padding: 10px; 
            border-radius: 8px; 
            font-size: 15px; 
            font-weight: bold; 
            margin-top: 20px;
            margin-bottom: 30px; 
            animation: fadeIn 1s ease-in-out; 
            cursor: pointer;
        }

        .count-box:hover, .count-box1:hover {
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Client Dashboard</h1>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <div class="count-box" onclick="window.location.href='edit_profile.php'">👥 Account</div>
        <div class="count-box" onclick="window.location.href='addproduct.php'">➕ Buy Product</div>
        <div class="count-box" onclick="window.location.href='manageproduct.php'">🏢 Company</div>
        <div class="count-box" onclick="window.location.href='#'">🛒 Cart</div>
        <div class="count-box" onclick="window.location.href='#'">📊 View Orders</div> 
        <div class="count-box1" onclick="window.location.href='/parksystem/logout.php'">🔒 Sign Out</div> 
    </div>

    <!-- Client Info Section -->
    <div class="user-info">
        <h3>Client Info</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($clientName) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($clientEmail) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($clientPhone) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($clientAddress) ?></p>
    </div>

    <!-- Orders & Cart Summary Section -->
    <div class="container">
        <div class="box">
            🛒 Cart Items: <?= $cartItemsCount ?>
        </div>
        <div class="box">
            📦 Orders: <?= $ordersCount ?>
        </div>
        <div class="box">
            🏷️ Account Status: Active
        </div>
    </div>

</body>
</html>
