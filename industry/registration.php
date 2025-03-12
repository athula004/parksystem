<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industry Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 15px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        fieldset {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        legend {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 1.2em;
        }
        .form-label {
            font-weight: bold;
        }
        .text-center {
            margin-top: 20px;
        }
        .password-error {
            color: red;
            font-size: 0.9em;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Industry Registration Form</h2>
        <div class="card shadow p-4">
            <form action="industrydashboard.php" method="POST" enctype="multipart/form-data" onsubmit="return validatePassword()">
                
                <!-- Industry Details Section -->
                <fieldset>
                    <legend>Industry Details</legend>
                    <div class="mb-3">
                        <label class="form-label">Industry Name</label>
                        <input type="text" class="form-control" name="industry_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Owner Name</label>
                        <input type="text" class="form-control" name="owner_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Industry Description</label>
                        <textarea class="form-control" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Land Requirement (in acres)</label>
                        <input type="number" class="form-control" name="land_required" min="1" required>
                    </div>
                </fieldset>

                <!-- Contact Information Section -->
                <fieldset>
                    <legend>Contact Information</legend>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="3" required></textarea>
                    </div>
                </fieldset>

                <!-- Password Section -->
                 <fieldset>
                    <legend>Password</legend>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
                        <div class="password-error" id="password-error">Passwords do not match.</div>
                    </div>

                 </fieldset>


                <!-- Document Upload Section -->
                <fieldset>
                    <legend>Required Documents</legend>
                    <div class="mb-3">
                        <label class="form-label">Business Registration Document</label>
                        <input type="file" class="form-control" name="business_doc" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Identity Proof</label>
                        <input type="file" class="form-control" name="id_proof" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Proof</label>
                        <input type="file" class="form-control" name="address_proof" required>
                    </div>
                </fieldset>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validatePassword(){
            const password=document.getElementById('password').value;
            const confirmPassword=document.getElementById('confirm_password').value;
            const passwordError=document.getElementById('password-error');

            if(password!==confirmPassword){
                passwordError.style.display='block';
                return false;
            }
            else
            {
                passwordError.style.display='none';
                return true;
            }
        }
    </script>


    <?php
    if(isset($_POST['submit'])){
        $industry_name = $_POST['industry_name'];
        $owner_name = $_POST['owner_name'];
        $description = $_POST['description'];
        $land_required = $_POST['land_required'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        // Process the form data here
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>