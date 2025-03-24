<?php
// PHP Backend Logic
require '../db.php'; // MongoDB connection
require '../check_role.php';
checkRole(["staff"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $stock_quantity = $_POST["stock_quantity"];
    $stock_unit = $_POST["stock_unit"]; // New field for unit
    $status = $_POST["status"]; 

    // Validate required fields
    if (empty($name) || empty($description) || $price <= 0 || $stock_quantity <= 0 || empty($stock_unit)) {
        echo '<script>alert("Please fill in all fields correctly.");</script>';
        exit;
    }

    // Handle file upload
    if (isset($_FILES["photo"]) && ($_FILES["photo"]["error"]) === UPLOAD_ERR_OK) {
        $photoDir = __DIR__ . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "raw_materials" . DIRECTORY_SEPARATOR;

        // Create directory if it doesn't exist
        if (!is_dir($photoDir)) {
            mkdir($photoDir, 0777, true);
        }

        $photoName = time() . "_" . basename($_FILES["photo"]["name"]);
        $photoPath = $photoDir . $photoName;
        $allowedExtensions = ["jpg", "jpeg", "png"];
        $fileExtension = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo '<script>alert("Invalid file type. Only JPG, JPEG and PNG files are allowed.");</script>';
            exit;
        }

        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath)) {
            $photoPath = "uploads/raw_materials/" . $photoName;
        } else {
            echo '<script>alert("Failed to upload image!");</script>';
            exit;
        }
    } else {
        echo '<script>alert("Please upload a valid image file!");</script>';
        exit;
    }

    // Insert into raw-materials collection
    $rawMaterialInsertResult = $rawMaterialCollection->insertOne([
        "name" => $name,
        "description" => $description,
        "price" => $price, // Ensure this is stored as a number
        "stock_quantity" => $stock_quantity . " " . $stock_unit, // Combine quantity and unit
        "photo" => $photoPath,
        "status" => $status
    ]);

    if ($rawMaterialInsertResult->getInsertedCount() > 0) {
        echo '<script>alert("Raw Material Added Successfully!"); window.location.href="staffdashboard.php";</script>';
    } else {
        echo '<script>alert("Error adding raw material!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Raw-Materials</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #000000, #444444);
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px;
            animation: fadeIn 1s ease-in-out;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        input, textarea, select {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: 0.3s;
        }
        input:focus, textarea:focus, select:focus {
            border-color: #000;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        textarea {
            resize: none;
            height: 80px;
        }
        button {
            background: black;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: 0.3s;
        }
        button:hover {
            background: #333;
            transform: scale(1.05);
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
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <script>
        function validateForm() {
            let price = document.forms["staffForm"]["price"].value;
            let stockQuantity = document.forms["staffForm"]["stock_quantity"].value;
            
            if (price <= 0) {
                alert("Price must be greater than zero.");
                return false;
            }

            if (stockQuantity <= 0) {
                alert("Stock quantity must be greater than zero.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <a href="javascript:history.back()" class="back-btn">← Back</a>
    <div class="container">
        <h2>Add Raw-Materials</h2>
        <form name="staffForm" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="number" name="price" placeholder="Price" required step="0.01">
            <input type="number" name="stock_quantity" placeholder="Stock Quantity" required>
            <select name="stock_unit" required>
                <option value="kg">kg</option>
                <option value="meters">meters</option>
                <option value="liters">liters</option>
                <option value="units">units</option>
            </select>
            <input type="file" name="photo" accept=".jpg,.jpeg,.png" required>
            <select name="status" required>
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <button type="submit">ADD</button>
        </form>
    </div>
</body>
</html>