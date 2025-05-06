<?php
require '../db.php'; // MongoDB connection
require '../check_role.php';
checkRole(["admin"]);

use MongoDB\BSON\ObjectId;

$userId = $_GET['user_id'] ?? null;
$error = "";
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($newPassword) || empty($confirmPassword)) {
        $error = "Both password fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        try {
            $objectId = new ObjectId($userId);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateResult = $usersCollection->updateOne(
                ['_id' => $objectId],
                ['$set' => ['password' => $hashedPassword]]
            );

            if ($updateResult->getModifiedCount() > 0) {
                $success = "Password updated successfully.";
            } else {
                $error = "Password update failed.";
            }
        } catch (Exception $e) {
            $error = "Invalid User ID.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Industry Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: black;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #333;
        }

        .message {
            margin-top: 15px;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
        }

        .error {
            background: #e74c3c;
            color: white;
        }

        .success {
            background: #2ecc71;
            color: white;
        }

        .home-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: black;
            color: white;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.95rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .home-button:hover {
            background-color: black;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<a href="admin_dashboard.php" class="home-button">Back</a>

<div class="container">
    <h2>Reset Password</h2>

    <?php if ($error): ?>
        <div class="message error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="message success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if ($userId && !$success): ?>
        <form method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required>

            <button type="submit">Update Password</button>
        </form>
    <?php elseif (!$userId): ?>
        <p class="message error">Invalid request. No user selected.</p>
    <?php endif; ?>
</div>


</body>
</html>