<?php
require '../db.php'; // MongoDB connection
// require '../check_role.php';
// checkRole(["admin"]);

// Fetch all clients
$clients = $clientsCollection->find()->toArray();

// Handle Approve/Reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["client_id"]) && isset($_POST["action"])) {
        $clientId = new MongoDB\BSON\ObjectId($_POST["client_id"]);
        $action = $_POST["action"];

        // Find the client document
        $client = $clientsCollection->findOne(["_id" => $clientId]);

        if ($client) {
            $userId = $client["_id"] ?? null; // Get the ObjectId of the user

            if ($userId) {
                $userObjectId = new MongoDB\BSON\ObjectId($userId);

                if ($action === "approve") {
                    $newUserStatus = "active";
                    $newApprovalStatus = "approved";
                } else {
                    $newUserStatus = "inactive";
                    $newApprovalStatus = "rejected";
                }

                // Update user collection status
                $usersCollection->updateOne(
                    ["_id" => $userObjectId],
                    ['$set' => ["status" => $newUserStatus]]
                );

                // Update client collection approval_status
                $clientsCollection->updateOne(
                    ["_id" => $clientId],
                    ['$set' => ["approval_status" => $newApprovalStatus]]
                );

                echo '<script>alert("Client status updated successfully."); window.location.href="client_approve.php";</script>';
            } else {
                echo '<script>alert("User ID not found in client collection.");</script>';
            }
        } else {
            echo '<script>alert("Client not found.");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Approve Clients</title>
    <link rel="stylesheet" href="../styles.css"> <!-- Your CSS file -->
</head>
<body>
<a href="../admin_dashboard.php" class="back-btn">← Back</a>

<h2>Approve Clients</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Address</th>
            <th>ID Proof</th>
            <th>Approval Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?php echo htmlspecialchars($client['name'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($client['phone'] ?? 'N/A'); ?></td>
                <td><?php echo htmlspecialchars($client['address'] ?? 'N/A'); ?></td>
                <td>
                    <?php if (!empty($client['id_proof'])): ?>
                        <a href="<?php echo htmlspecialchars($client['id_proof']); ?>" target="_blank">View</a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($client['approval_status'] ?? 'Pending'); ?></td>
                <td>
                    <?php if ($client['approval_status'] === 'Pending'): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="client_id" value="<?php echo $client['_id']; ?>">
                            <button type="submit" name="action" value="approve" class="approve">Approve</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="client_id" value="<?php echo $client['_id']; ?>">
                            <button type="submit" name="action" value="reject" class="reject">Reject</button>
                        </form>
                    <?php else: ?>
                        <?php echo ucfirst($client['approval_status']); ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
