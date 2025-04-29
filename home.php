<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LandLink - Smart Industrial Park Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        body {
            background:rgba(255, 255, 255, 0.92);
            color: black;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }


        .container {
            max-width: 80%;
            margin-top: 80px;
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            font-size: 70px;
            font-weight: bold;
            text-transform: uppercase;
            color: black;
        }

        h2 {
            font-size: 24px;
            margin-top: 15px;
            color: gray;
        }

        p {
            font-size: 18px;
            margin-top: 15px;
            line-height: 1.6;
            color: white;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        .feature-box {
            background-color:rgb(34, 32, 32);
            color: white;
            padding: 20px;
            margin: 15px;
            border-radius: 10px;
            width: 250px;
            text-align: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .feature-box:hover {
            transform: scale(1.05);
            background-color: white;
            color: black;
            border: 2px solid black;

        }
        .feature-box:hover p, .feature-box:hover h3 {
            color: black;
        }
        .feature-box h3 {
            margin-top: 10px;
            color: white;
        }

        button {
            background-color: black;
            color: white;
            font-size: 18px;
            padding: 12px 25px;
            border: 2px solid black;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease-in-out;
            font-weight: bold;
        }

        button:hover {
            background-color: white;
            color: black;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .tagline {
            font-size: 20px;
            color: black;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .navbar {
            width: 100%;
            background-color: rgb(10, 10, 10);
            display: flex;
            justify-content: normal;
            gap: 14px;
            align-items: center;
            padding: 5px 20px;
            position: fixed;
            top: 1px;
            left: 0;
            z-index: 1000;
            font-family: "Poppins", sans-serif;
            border-radius: 5px;
        }
        .navbar a {
            color: white; 
            text-decoration: none;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .navbar a:hover {
            background-color: white;
            color: black;
            border-radius: 5px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .dropdown-content a {
            color: black;
            display: block;
            padding: 10px 15px;
            text-align: left;
        }
        .dropdown-content a:hover {
            background-color: rgb(240, 240, 240);
        }
        .navbar .cname {
            font-size: 20px;
            font-weight: 600;
        }
        .navbar .cname:hover {
            background-color: transparent;
            color: white;
        }
        .active {
        border-radius: 5px;
        border: 1px solid white; 
        }

    </style>
</head>
<body>

<div class="navbar">
        <a class="cname" href="index.php">LandLink</a>
        <a class="active"  href="home.php">Home</a>
        <a href="login.html">Login</a>

        <div class="dropdown">
            <a href="#">Industry ▼</a>
            <div class="dropdown-content">
                <a href="industry/checkindustry.php">Check Approval Status</a>
                <a href="industry/reg.php">Register</a>
            </div>
        </div>

        <div class="dropdown">
            <a href="#">Client ▼</a>
            <div class="dropdown-content">
                <a href="client/clientreg.php">Register</a>
                <a href="client/checkclient.php">Check Approval Status</a>
            </div>
        </div>

        <a href="industry/industry.php">Existing Industry</a>
        <a href="#">Products</a>
        <a href="landview.php">Plot</a>
        <a href="about.php">About Us</a>
    </div>
    
    <!-- Main Content -->
    <div class="container">
        <h1>Welcome to LandLink</h1>
        <h2>The Future of Smart Industrial Park Management</h2>
        <p class="tagline">
            Looking for a seamless and efficient way to establish and grow your industry?  
            LandLink simplifies **land leasing, raw material procurement, and product sales  
            all in one powerful platform**.  
        </p>

        <div class="features">
            <div class="feature-box">
                <h3>🏭 Hassle-Free Land Leasing</h3>
                <p>Secure prime industrial land quickly and efficiently.</p>
            </div>
            <div class="feature-box">
                <h3>⚡ High-Quality Raw Materials</h3>
                <p>Get instant access to top-grade raw materials at the best prices.</p>
            </div>
            <div class="feature-box">
                <h3>🛒 Sell Your Products</h3>
                <p>Showcase your industry’s products to a wide network of buyers.</p>
            </div>
            <div class="feature-box">
                <h3>🔍 Transparent & Reliable</h3>
                <p>Enjoy a system built on trust, efficiency, and security.</p>
            </div>
        </div>

        <!-- <button onclick="window.location.href='home.php'">Get Started</button> -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
</body>
</html>
