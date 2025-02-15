<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | LandLink</title>
    <style>
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
        body {
            margin: 0;
            padding: 0;
            font-family: "Poppins", sans-serif;
            background-color: white;
            color: black;
            line-height: 1.8;
            padding: 40px 20px;
        }

        .about-section {
            max-width: 900px;
            margin: auto;
            text-align: justify;
            padding-top: 36px;
            animation: fadeIn 1s ease-in-out;
        }

        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
            animation: fadeIn 1.5s ease-in-out;
            
        }
        p{
            animation: fadeIn 1.5s ease-in-out;
        }

        h2 {
            font-size: 28px;
            margin-top: 30px;
            color: black;
            animation: fadeIn 1.5s ease-in-out;
        }

        .btn {
            display: block;
            text-align: center;
            margin: 30px auto;
            padding: 12px 20px;
            background-color: black;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            width: 200px;
        }

        .btn:hover {
            background-color: white;
            color: black;
            border: 1px solid black;
        }

        footer {
            text-align: center;
            background: black;
            color: white;
            padding: 5px;
            margin-top: 50px;
            border-radius: 5px;
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
            font-size: 15px;
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
        <a class="cname" href="home.php">LandLink</a>
        <a href="home.php">Home</a>
        <a href="login.php">Login</a>

        <div class="dropdown">
            <a href="#">Industry ▼</a>
            <div class="dropdown-content">
                <a href="#">Check Approval Status</a>
                <a href="#">Register</a>
            </div>
        </div>

        <div class="dropdown">
            <a href="#">Client ▼</a>
            <div class="dropdown-content">
                <a href="#">Register</a>
                <a href="#">Check Approval Status</a>
            </div>
        </div>

        <a href="#">Existing Industry</a>
        <a href="#">Products</a>
        <a class="active" href="about.php">About Us</a>
    </div>
    <section class="about-section">
        <h1>About LandLink</h1>
        <p>
            <strong>LandLink</strong> is a next-generation industrial platform designed to revolutionize the way businesses acquire land, manage resources, and trade products. 
            We provide a seamless and secure digital space where industries can grow without limitations. Our mission is to streamline industrial operations by offering a transparent 
            and efficient system that connects businesses with the right resources.
        </p>

        <h2>What We Offer</h2>
        <p>
            LandLink simplifies the process of land leasing and registration for industries, ensuring a smooth approval system that eliminates unnecessary delays. 
            Businesses can purchase raw materials from verified suppliers and sell their products in a robust marketplace designed for growth. Our platform also provides 
            a dedicated dashboard for industries, clients, and staff, offering a user-friendly interface for managing operations effectively.
        </p>

        <h2>Our Vision</h2>
        <p>
            At LandLink, we envision a future where industrial development is streamlined, eco-friendly, and accessible to all businesses. 
            Our goal is to create a digitally powered industrial ecosystem that fosters growth, collaboration, and efficiency. 
            By embracing technology and innovation, we aim to empower industries and contribute to a more sustainable and productive economy.
        </p>

        <h2>Why Choose LandLink?</h2>
        <p>
            Our platform is designed to be user-friendly, offering a straightforward and transparent experience for all users. 
            We ensure 100% verified industries and clients, providing a secure business environment with no hidden costs. 
            Our automated approval system speeds up processing times, and our 24/7 customer support ensures that your business needs are always met.
        </p>

        <h2>Our Impact</h2>
        <p>
            LandLink is transforming the industrial landscape by making land acquisition, resource procurement, and product sales more accessible and efficient. 
            We have helped numerous industries establish themselves with ease, reducing costs and increasing productivity. 
            Our commitment to innovation and customer satisfaction continues to drive us toward making industrial growth a seamless experience for all.
        </p>
>
    </section>

    <footer>
        <p>&copy; 2025 LandLink. All Rights Reserved.</p>
    </footer>

</body>
</html>
