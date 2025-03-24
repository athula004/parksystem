<?php
require '../db.php'; // MongoDB connection
require '../check_role.php';
checkRole(["industry"]); // Only Admin can access this page

$productList = $productsCollection->find([]); // Fetch all products
$totalProducts = $productsCollection->countDocuments(); // Get total product count
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 20px; display: flex; }
        
        /* Sidebar */
        .sidebar { 
            width: 250px; 
            background: black; 
            color: white; 
            padding: 20px; 
            height: 100vh; 
            position: fixed; 
            top: 0; left: 0; 
            text-align: center; 
        }

        .count-box { 
            background: white; 
            color: black; 
            padding: 15px; 
            border-radius: 8px; 
            font-size: 20px; 
            font-weight: bold; 
            margin-top: 20px; 
            animation: fadeIn 1s ease-in-out; 
        }

        /* Main Content */
        .content { margin-left: 270px;
             width: calc(100% - 270px); }
        h2 { text-align: center; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background: black; color: white; }
        img { width: 50px; height: 50px; border-radius: 5px; }
        .edit-btn, .delete-btn { 
            background: black; 
            color: white; 
            padding: 5px 10px; 
            text-decoration: none; 
            border-radius: 5px; 
            margin: 2px;
        }
        .edit-btn:hover, .delete-btn:hover { background: #333; }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard</h2>
        <div class="count-box">📦 Total Products: <?= $totalProducts ?></div>
        <div class="count-box" onclick="window.location.href='../admin_dashboard.php'" style="cursor: pointer;">🏠 Home</div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Product List</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Category</th>
                <th>Image</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($productList as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product["name"]) ?></td>    
                    <td><?= htmlspecialchars($product["price"]) ?></td>
                    <td><?= htmlspecialchars($product["description"]) ?></td>
                    <td><?= htmlspecialchars($product["category"]) ?></td>
                    <td><img src="<?= htmlspecialchars($product["image"]) ?>" alt="Product Image"></td>
                    <td><?= htmlspecialchars($product["stock"]) ?></td>
                    <td>
                        <a class="edit-btn" href="productedit.php?id=<?= $product['_id'] ?>">Edit</a>
                        <a class="delete-btn" href="productdelete.php?id=<?= $product['_id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</body>
</html>