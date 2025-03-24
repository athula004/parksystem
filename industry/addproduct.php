<?php
require '../db.php'; 

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    $category = trim($_POST['category']);

    
    $existingProduct = $productsCollection->findOne(['product_name' => $productName]);
    if ($existingProduct) {
        $error = "Product already exists.";
    } else {
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
            $targetDir = "uploads/product_images/";
            
            
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
        
            $fileName = uniqid() . "_" . basename($_FILES['product_image']['name']);
            $targetFilePath = $targetDir . $fileName;
        
            
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
                if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFilePath)) {

                    
                    $productsCollection->insertOne([
                        "product_name" => $productName,
                        "description" => $description,
                        "price" => $price,
                        "quantity" => $quantity,
                        "category" => $category,
                        "product_image" => $targetFilePath, 
                        "created_at" => new MongoDB\BSON\UTCDateTime()
                    ]);
                    
                    $success = "Product added successfully!";
                } else {
                    $error = "File upload failed.";
                }
            } else {
                $error = "Invalid file type. Only JPG, PNG allowed.";
            }
        } else {
            $error = "Product image is required.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
       body { 
    font-family: Arial, sans-serif; 
    background: linear-gradient(to right,rgb(176, 178, 180),rgb(56, 57, 58)); 
    color: #333; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
    height: 100vh; 
    margin: 0; 
}

.container { 
    width: 100%; 
    max-width: 400px; 
    background: #fff; 
    padding: 25px; 
    border-radius: 10px; 
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); 
    text-align: center; 
}

h2 { 
    color: #333; 
    margin-bottom: 15px; 
}

input, button , textarea { 
    width: calc(100% - 20px); 
    padding: 12px; 
    margin: 8px 0; 
    border: 1px solid #ccc; 
    border-radius: 8px; 
    font-size: 16px; 
}

input:focus { 
    border-color: #2a5298; 
    outline: none; 
    box-shadow: 0px 0px 5px rgba(42, 82, 152, 0.5); 
}

button { 
    background:rgb(0, 6, 2); 
    color: white; 
    font-weight: bold; 
    border: none; 
    cursor: pointer; 
    transition: 0.3s ease; 
}

button:hover { 
    background:rgb(1, 7, 2); 
    transform: scale(1.05); 
}

.error { 
    color: red; 
    font-size: 14px; 
    margin-bottom: 10px; 
}

.success { 
    color: green; 
    font-size: 14px; 
    font-weight: bold; 
    margin-bottom: 10px; 
}

p { 
    margin-top: 10px; 
    font-size: 14px; 
}

a { 
    color: #2a5298; 
    text-decoration: none; 
    font-weight: bold; 
}

a:hover { 
    text-decoration: underline; 
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

<a href="industrydashboard.php" class="back-btn">← Back</a>
<div class="container">
    <h2>Add Product</h2>

    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="product_name" required placeholder="Product Name">
        <textarea name="description" required placeholder="Description" rows="3"></textarea>
        <input type="number" name="price" required placeholder="Price">
        <input type="number" name="quantity" required placeholder="Quantity">
        <input type="text" name="category" required placeholder="Category">
        <input type="file" name="product_image" required accept="image/*">
        <button type="submit">Add Product</button>
    </form>
</div>

</body>
</html>