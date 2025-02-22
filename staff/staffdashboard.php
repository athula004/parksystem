<?php
require '../db.php'; // MongoDB connection
// require '../check_role.php';
// checkRole(["admin"]);

// Fetch all staff details from MongoDB
$staffList = $staffCollection->find()->toArray();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff</title>
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
            width: 80%;
            max-width: 800px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: black;
            color: white;
        }
        img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Staff List</h2>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffList as $staff): ?>
                <?php 
                    // Fetch user details using user_id
                    $user = $usersCollection->findOne(["_id" => $staff["user_id"]]);
                    $email = $user ? $user["email"] : "N/A"; 
                ?>
                <tr>
                    <td>
                        <img src="<?php echo $staff["photo"]; ?>" alt="Staff Image">
                    </td>
                    <td><?php echo htmlspecialchars($staff["name"]); ?></td>
                    <td><?php echo htmlspecialchars($email); ?></td>
                    <td><?php echo htmlspecialchars($staff["age"]); ?></td>
                    <td><?php echo htmlspecialchars($staff["address"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
