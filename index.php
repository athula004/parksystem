<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LandLink - Smart Industrial Park Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        body {
            background: linear-gradient(to right, rgb(0, 0, 0), rgb(69, 71, 71));
            color: white;
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
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            font-size: 90px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: rgb(251, 255, 250);
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
        }

        h2 {
            font-size: 30px;
            font-weight: 400;
            margin-top: 10px;
        }

        .tagline {
            font-size: 20px;
            font-weight: 300;
            margin-top: 10px;
            color: rgb(189, 189, 189);
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 40px;
        }

        .feature-box {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 20px;
            margin: 15px;
            border-radius: 10px;
            width: 280px;
            text-align: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
        }

        .feature-box:hover {
            transform: scale(1.05);
            background-color: white;
            color: black;
            border: 2px solid white;
        }

        .feature-box:hover p, .feature-box:hover h3 {
            color: black;
        }

        .feature-box h3 {
            margin-top: 10px;
        }

        button {
            background-color: rgb(252, 255, 252);
            color: black;
            font-size: 20px;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 30px;
            transition: all 0.3s ease-in-out;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            background-color: rgb(184, 189, 184);
            transform: scale(1.1);
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
    </style>
</head>
<body>

    <div class="container">
        <h1>LandLink</h1>
        <h2>Welcome to <span class="typedname"></span></h2>
        <p class="tagline">Effortlessly lease land, acquire top-quality raw materials, and sell your products in a seamless ecosystem.</p>

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

        <button onclick="window.location.href='home.php'">Get Started</button>
    </div>

   
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        var typed = new Typed(".typedname", {
            strings: ["Industrial Park", "Smart Business Hub", "Future of Industry"],
            typeSpeed: 100,
            backSpeed: 100,
            loop: true
        });
    </script>

</body>
</html>
