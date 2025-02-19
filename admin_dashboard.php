<?php
require 'check_role.php';
checkRole(["admin"]);
// echo "Welcome, Admin!";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background: black;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .user-info {
            display: flex;
            align-items: center;
        }
        .user-info span {
            margin-right: 15px;
        }
        .logout-button {
            background: red;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .container {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            
        }
        .box a {
            text-decoration: none;
            color: black;
        }
        .box:hover {
            background: #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Admin Dashboard</h2>
        <div class="user-info">
            <span>Admin</span>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
    <div class="container">
        <div class="box"><a href="staff/staffreg.php">Add Staff</a> </div>
        <div class="box">Manage Staff</div>
        <div class="box">View Reports</div>
        <div class="box">Manage Industry</div>
        <div class="box">Approve Industry</div>
        <div class="box">Add Raw Materials</div>
        <div class="box">Messages</div>
    </div>
</body>
</html>

