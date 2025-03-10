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
        <h2 class="mb-4">Industry Registration Form</h2>
        <form action="submit.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Industry Name</label>
                <input type="text" class="form-control" name="industry_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Owner Name</label>
                <input type="text" class="form-control" name="owner_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="tel" class="form-control" name="phone" required>
            </div>
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
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>