<?php
session_start();
include 'db.php'; // Database connection

// Logged-in user ID (replace with session after login)
$userId = $_SESSION['user_id'] ?? 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $productName   = $_POST['productName'];
    $description   = $_POST['description'];
    $price         = $_POST['price'];
    $stockQuantity = $_POST['stockQuantity'];
    $category      = $_POST['category'];
    $createdByForm = $_POST['createdBy']; // optional

    // Handle image upload
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO products (productName, description, price, stockQuantity, category, image, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisii", $productName, $description, $price, $stockQuantity, $category, $imageName, $userId);

    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request.";
}
?>
