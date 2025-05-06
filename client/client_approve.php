<?php
require '../db.php'; // MongoDB connection
require '../check_role.php';
checkRole(["staff"]);

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
            $userId = $client["user_id"] ?? null;

            if ($userId) {
                if ($action === "approve") {
                    $newUserStatus = "active";
                    $newApprovalStatus = "approved";
                } else {
                    $newUserStatus = "inactive";
                    $newApprovalStatus = "rejected";
                }

                $usersCollection->updateOne(
                    ["_id" => $userId],
                    ['$set' => ["status" => $newUserStatus]]
                );

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
<title>Approve Clients - LandLink</title>
<style>
    body {
        background-color: white;
        margin: 0;
        padding: 40px 20px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: black;
    }

    .home-button {
        position: absolute;
        top: 20px;
        left: 20px;
        background: black;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
    }

    .home-button:hover {
        background: #333;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid black;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    th, td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: black;
        color: white;
        font-size: 16px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    a {
        color: #2980b9;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    .approve, .reject {
        padding: 8px 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        color: white;
        margin: 2px;
    }

    .approve {
        background-color: #2ecc71;
    }

    .approve:hover {
        background-color: #27ae60;
    }

    .reject {
        background-color: #e74c3c;
    }

    .reject:hover {
        background-color: #c0392b;
    }

    .status-approved {
        color: #2ecc71;
        font-weight: bold;
    }

    .status-rejected {
        color: #e74c3c;
        font-weight: bold;
    }

    .status-pending {
        color: #f39c12;
        font-weight: bold;
    }

</style>
</head>
<body>

<a href="../staff/staffdashboard.php" class="home-button">Dashboard</a>

<h2>Approve Clients</h2>

<table>
<thead>
<tr>
    <th>Name</th>
    <th>Email</th>
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
        <td><?php echo htmlspecialchars($client['email'] ?? 'N/A'); ?></td>
        <td><?php echo htmlspecialchars($client['phone'] ?? 'N/A'); ?></td>
        <td><?php echo htmlspecialchars($client['address'] ?? 'N/A'); ?></td>
        <td>
            <?php if (!empty($client['id_proof']) && file_exists($client['id_proof'])): ?>
                <a href="<?php echo htmlspecialchars($client['id_proof']); ?>" target="_blank">View</a>
            <?php else: ?>
                N/A
            <?php endif; ?>
        </td>
        <?php
            $status = strtolower($client['approval_status'] ?? 'pending');
            $statusClass = 'status-' . $status;
        ?>
        <td class="<?php echo $statusClass; ?>">
            <?php echo ucfirst($status); ?>
        </td>
        <td>
            <?php if (strtolower($client['approval_status']) === 'pending'): ?>
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