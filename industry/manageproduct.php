<?php
require '../db.php'; // MongoDB connection

// Fetch all products
$productCollection = $database->products;
$products = $productCollection->find();

// Handle Edit Product
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit_product'])) {
    $id = new MongoDB\BSON\ObjectId($_POST['product_id']);

    $updateResult = $productCollection->updateOne(
        ["_id" => $id],
        ['$set' => [
            $productName = trim($_POST['product_name']),
    $description = trim($_POST['description']),
    $price = trim($_POST['price']),
    $quantity = trim($_POST['quantity']),
    $category = trim($_POST['category']),
        ]]
    );

    if ($updateResult->getModifiedCount() > 0) {
        echo "<script>alert('Product Updated Successfully!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error updating product!');</script>";
    }
}

// Handle Delete Product
if (isset($_GET['delete_id'])) {
    $id = new MongoDB\BSON\ObjectId($_GET['delete_id']);
    $deleteResult = $productCollection->deleteOne(["_id" => $id]);

    if ($deleteResult->getDeletedCount() > 0) {
        echo "<script>alert('Product Deleted!'); window.location.href='manage_products.php';</script>";
    } else {
        echo "<script>alert('Error deleting product!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <a href="industrydashboard.php" class="btn btn-secondary mb-3">⬅ Back to Dashboard</a>
        <h2 class="mb-4">Manage Products</h2>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 1; foreach ($products as $product) { ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= htmlspecialchars($product['product_name']); ?></td>
                    <td><?= htmlspecialchars($product['description']); ?></td>
                    <td>$<?= htmlspecialchars($product['price']); ?></td>
                    <td><?= htmlspecialchars($product['quantity']); ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editProductModal<?= $product['_id']; ?>">✏ Edit</button>
                        <a href="?delete_id=<?= $product['_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">🗑 Delete</a>
                    </td>
                </tr>

                <!-- Edit Modal for each Product -->
                <div class="modal fade" id="editProductModal<?= $product['_id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="" method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="product_id" value="<?= $product['_id']; ?>">
                                
                                <label>Name:</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['product_name']); ?>" required>

                                <label>Description:</label>
                                <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($product['description']); ?>" required>

                                <label>Stock Quantity:</label>
                                <input type="number" name="stock_quantity" class="form-control" value="<?= htmlspecialchars($product['stock_quantity']); ?>" required>

                                <label>Price:</label>
                                <input type="number" name="price" class="form-control" value="<?= htmlspecialchars($product['price']); ?>" step="0.01" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>
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