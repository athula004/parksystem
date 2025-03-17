<?php
require '../db.php'; // Ensure db.php is included correctly

use MongoDB\BSON\ObjectId;

$industryData = null;
$error = "";
$approval_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Check if user exists
    $user = $usersCollection->findOne(['email' => $email]);

    if (!$user) {
        $error = "No user found for this email.";
    } else {
        // Fetch industry details using the user's ObjectId
        $industry = $industriesCollection->findOne(['user_id' => new ObjectId($user['_id'])]);

        if ($industry) {
            $industryData = [
                "industry_name" => $industry['industry_name'] ?? 'N/A',
                "contact" => $industry['contact'] ?? 'N/A',
                "address" => $industry['address'] ?? 'N/A',
                "description" => $industry['description'] ?? 'N/A',
                "logo" => $industry['logo'] ?? '',
                "certificate" => $industry['certificate'] ?? '',
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industry Approval Check</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f4; }
        .container { margin: 50px auto; width: 50%; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .error { color: red; }
        .approved { color: green; font-weight: bold; }
        .pending { color: orange; font-weight: bold; }
        .rejected { color: red; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background: #f2f2f2; }
        img { max-width: 100px; }
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            background: black;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
        }
        .back-btn:hover {
            background: #333;
        }


    </style>
</head>
<body>


<a href="../home.php" class="back-btn">← Back</a>
<div class="container">
    <h2>Industry Approval Check</h2>
    
    <form method="POST">
        <input type="email" name="email" required placeholder="Enter Industry Email">
        <button type="submit">Check Approval</button>
    </form>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($industryData): ?>
        <h3>Approval Status: 
            <span class="<?php echo strtolower($approval_status); ?>">
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
                <th>Certificate</th>
            </tr>
            <tr>
                <td><?php echo $industryData['industry_name']; ?></td>
                <td><?php echo $industryData['contact']; ?></td>
                <td><?php echo $industryData['address']; ?></td>
                <td><?php echo $industryData['description']; ?></td>
                <td><?php echo $industryData['logo'] ? "<img src='{$industryData['logo']}' alt='Logo'>" : 'N/A'; ?></td>
                <td><?php echo $industryData['certificate'] ? "<a href='{$industryData['certificate']}' target='_blank'>View Certificate</a>" : 'N/A'; ?></td>
            </tr>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
