<?php
require 'db.php'; // Include MongoDB connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $user = $usersCollection->findOne(["email" => $email]);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = (string) $user["_id"];
        $_SESSION["role"] = $user["role"];

        switch ($user["role"]) {
            case "admin":
                header("Location: admin_dashboard.php");
                break;
            case "staff":
                header("Location: staff_dashboard.php");
                break;
            case "industry":
                header("Location: industry_dashboard.php");
                break;
            case "client":
                header("Location: client_dashboard.php");
                break;
            default:
                echo "Invalid role!";
        }
        exit;
    } else {
        echo '<script type="text/javascript">
                alert("Invalid email or password!");
                window.location.href = "login.html";
              </script>';
        exit;
    }
}
?>
