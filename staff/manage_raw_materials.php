<?php
require '../db.php'; // MongoDB connection

// Fetch all raw materials
$rawMaterialCollection = $database->raw_material;
$rawMaterials = $rawMaterialCollection->find();

// Handle Edit Raw Material
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_material'])) {
    $id = new MongoDB\BSON\ObjectId($_POST['material_id']);

    $updateResult = $rawMaterialCollection->updateOne(
        ["_id" => $id],
        ['$set' => [
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "price" => (float)$_POST['price'], // Ensure price is stored as a float
            "stock_quantity" => $_POST['stock_quantity'],
        ]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo "<script>alert('Raw Material Updated Successfully!'); window.location.href='manage_raw_materials.php';</script>";
    } else {
        echo "<script>alert('Error updating raw material!');</script>";
    }
}

// Handle Delete Raw Material
if (isset($_GET['delete_id'])) {
    $id = new MongoDB\BSON\ObjectId($_GET['delete_id']);
    $deleteResult = $rawMaterialCollection->deleteOne(["_id" => $id]);

    if ($deleteResult->getDeletedCount() > 0) {
        echo "<script>alert('Raw Material Deleted!'); window.location.href='manage_raw_materials.php';</script>";
    } else {
        echo "<script>alert('Error deleting raw material!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Raw Materials</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
    <a href="staffdashboard.php" class="btn btn-secondary mb-3">⬅ Back to Dashboard</a>
        <h2 class="mb-4">Manage Raw Materials</h2>
        

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price/Kg</th>
                    <th>Stock Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; foreach ($rawMaterials as $material) { ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($material['name']); ?></td>
                    <td><?= htmlspecialchars($material['description']); ?></td>
                    <td>₹<?= htmlspecialchars($material['price']); ?></td>
                    <td><?= htmlspecialchars($material['stock_quantity']); ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editMaterialModal<?= $material['_id']; ?>">✏ Edit</button>
                        <a href="?delete_id=<?= $material['_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">🗑 Delete</a>
                    </td>
                </tr>

                <!-- Edit Modal for each Raw Material -->
                <div class="modal fade" id="editMaterialModal<?= $material['_id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="" method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Raw Material</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="material_id" value="<?= $material['_id']; ?>">
                                
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($material['name']); ?>" required>

                                <label>Description:</label>
                                <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($material['description']); ?>" required>

                                <label>Stock Quantity:</label>
                                <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($material['stock_quantity']); ?>" required>

                                <label>Price:</label>
                                <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($material['price']); ?>" step="0.01" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_material" class="btn btn-primary">Save Changes</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>