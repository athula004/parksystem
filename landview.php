<?php
require 'db.php';

$filesCollection = $database->selectCollection("fs.files");
$images = $filesCollection->find([]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Land Photos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color:rgb(255, 255, 255);
            padding: 20px;
        }
        .image-container {
            display: inline-block;
            border: 2px solid black;
            margin: 10px;
            padding: 10px;
            background: white;
        }
        img {
            width: 300px;
            height: auto;
            border-bottom: 2px solid black;
        }
        .info {
            padding: 10px;
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
           
        }
        .back-btn:hover {
            background: #333;
        }
    </style>
</head>
<body>
<a href="javascript:history.back()" class="back-btn">← Back</a>
    <h1>Uploaded Land Photos</h1>
    <?php
    foreach ($images as $image) {
        echo '<div class="image-container">';
        echo '<img src="fetch_image.php?id=' . $image['_id'] . '" alt="Uploaded Image">';
        echo '<div class="info">';
        echo '<p><strong>Title:</strong> ' . htmlspecialchars($image->metadata['title']) . '</p>';
        echo '<p><strong>Description:</strong> ' . htmlspecialchars($image->metadata['description']) . '</p>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</body>
</html>
