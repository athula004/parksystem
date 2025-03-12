<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Industry Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Industry Registration Form</h2>
        <div class="card shadow p-4">
            <form action="industrydashboard.php" method="POST" enctype="multipart/form-data">
                
                <!-- Industry Details Section -->
                <fieldset class="border p-3 mb-4">
                    <legend class="float-none w-auto px-2">Industry Details</legend>
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
                <fieldset class="border p-3 mb-4">
                    <legend class="float-none w-auto px-2">Contact Information</legend>
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

                <!-- Document Upload Section -->
                <fieldset class="border p-3 mb-4">
                    <legend class="float-none w-auto px-2">Required Documents</legend>
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
                    <button type="submit" name="submit" class="btn btn-primary px-4">Register</button>
                </div>
            </form>
        </div>
    </div>
    <?php
if(isset($_POST['submit'])){
    $industry_name = $_POST['industry_name'];
    $owner_name = $_POST['owner_name'];
    $desciption = $_POST['description'];
    $land_required = $_POST['land_required'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

}

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
