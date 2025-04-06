<?php
require '../db.php';

$products = $productsCollection->find([]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, rgb(176, 178, 180), rgb(56, 57, 58));
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: rgb(0, 6, 2);
            color: white;
        }
        img {
            width: 60px;
            height: 60px;
            border-radius: 5px;
        }
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
            transition: background 0.3s;
        }
        .back-btn:hover {
            background: #333;
        }
    </style>
</head>
<body>

<a href="staffdashboard.php" class="back-btn">&larr; Back</a>
<div class="container">
    <h2>View Products</h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Image</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td>
                    <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Product Image">
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
