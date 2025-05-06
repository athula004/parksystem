<?php
require '../db.php';

use MongoDB\BSON\ObjectId;

$industryData = null;
$error = "";
$approval_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $user = $usersCollection->findOne(['email' => $email]);

    if (!$user) {
        $error = "No user found for this email.";
    } else {
        $industry = $industriesCollection->findOne(['user_id' => new ObjectId($user['_id'])]);

        if ($industry) {
            $industryData = [
                "industry_name" => $industry['industry_name'] ?? 'N/A',
                "contact" => $industry['contact'] ?? 'N/A',
                "address" => $industry['address'] ?? 'N/A',
                "description" => $industry['description'] ?? 'N/A',
                "logo" => $industry['logo'] ?? '',
            ];
            $approval_status = $industry['approval_status'] ?? 'Pending';
        } else {
            $error = "Industry details not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Industry Approval Check</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family:'Poppins', sans-serif;
            background-color: white; /* White background for the entire page */
        }

        .back-btn {
            display: inline-block;
            margin: 20px;
            text-decoration: none;
            color: white; /* Change to black color */
            border: 1px solid #ddd;
            padding: 8px 16px;
            background: black; /* White background for the button */
            border-radius: 4px;
        }

        .back-btn:hover {
            background:rgb(8, 10, 10);
        }

        .main-content {
            padding: 40px 20px;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="email"] {
            padding: 10px;
            width: 60%;
            border: 1px solid #ddd;
            margin-right: 10px;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            border: 1px solid #ddd;
            background: black; /* Change button color to black */
            cursor: pointer;
            color: white;
            border-radius: 4px;
        }

        button:hover {
            background: #333; /* Darker black shade on hover */
        }

        .error {
            color: #e74c3c;
            font-weight: bold;
            text-align: center;
        }

        .approved, .pending, .rejected {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        img {
            max-width: 100px;
            height: auto;
        }

        .status-approved {
            color: #2ecc71;
        }

        .status-pending {
            color: #f39c12;
        }

        .status-rejected {
            color: #e74c3c;
        }

    </style>
</head>
<body>

<div class="header">
    <a href="../home.php" class="back-btn">← Back to Home</a>
</div>

<div class="main-content">
    <h2>Check Industry Approval Status</h2>

    <form method="POST">
        <input type="email" name="email" required placeholder="Enter Industry Email">
        <button type="submit">Check Approval</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($industryData): ?>
        <h3>Approval Status:
            <span class="status-<?php echo strtolower($approval_status); ?>">
                <?php echo ucfirst($approval_status); ?>
            </span>
        </h3>

        <table>
            <tr>
                <th>Industry Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Description</th>
                <th>Logo</th>
            </tr>
            <tr>
                <td><?php echo $industryData['industry_name']; ?></td>
                <td><?php echo $industryData['contact']; ?></td>
                <td><?php echo $industryData['address']; ?></td>
                <td><?php echo $industryData['description']; ?></td>
                <td>
                    <?php echo $industryData['logo'] ? "<img src='{$industryData['logo']}' alt='Logo'>" : 'N/A'; ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>
</div>

</body>
</html>