<?php
require '../db.php'; // MongoDB connection
require '../check_role.php';
checkRole(["staff"]);

// Fetch all clients
$clients = $clientsCollection->find()->toArray();

// Handle Active/Inactive action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["set_status"])) {
    $clientId = new MongoDB\BSON\ObjectId($_POST["client_id"]);
    $client = $clientsCollection->findOne(["_id" => $clientId]);

    if (isset($client["user_id"])) {
        $userId = $client["user_id"];
        $user = $usersCollection->findOne(["_id" => $userId]);
        $currentStatus = $user['status'] ?? 'inactive';
        $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';

        $usersCollection->updateOne(
            ["_id" => $userId],
            ['$set' => ["status" => $newStatus]]
        );

        echo '<script>alert("Client status updated successfully."); window.location.href="manage_client.php";</script>';
    }
}

// Handle Delete Client action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_client"])) {
    $clientId = new MongoDB\BSON\ObjectId($_POST["client_id"]);
    $client = $clientsCollection->findOne(["_id" => $clientId]);

    if ($client) {
        if (isset($client["user_id"])) {
            $userId = $client["user_id"];
            $usersCollection->deleteOne(["_id" => new MongoDB\BSON\ObjectId($userId)]);
        }
        $clientsCollection->deleteOne(["_id" => $clientId]);

        echo '<script>alert("Client and related user deleted successfully."); window.location.href="manage_client.php";</script>';
    } else {
        echo '<script>alert("Client not found."); window.location.href="manage_client.php";</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff - Manage Clients</title>
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

<h2>Manage Clients</h2>

<table>
<thead>
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Address</th>
    <th>ID Proof</th>
    <th>Status</th>
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
            <form method="POST" style="display:inline;">
                <input type="hidden" name="client_id" value="<?php echo $client['_id']; ?>">
                <button type="submit" name="set_status" class="approve"><?php echo $status === 'approved' ? 'Deactivate' : 'Activate'; ?></button>
            </form>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="client_id" value="<?php echo $client['_id']; ?>">
                <button type="submit" name="delete_client" class="reject">Delete</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>

</body>
</html>