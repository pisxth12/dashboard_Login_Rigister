<?php
session_start();
include "db.php";

$productName = $_POST['productName'] ?? '';
$price = (float)($_POST['price'] ?? 0);
$description = $_POST['description'] ?? '';

if(empty($productName) || $price <= 0){
    echo json_encode(["status"=>"error", "message"=>"Product name and valid price are required"]);
    exit;
}

$imageName = "";
if(isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0){
    $imageDir = "productImage/";
    if(!is_dir($imageDir)) mkdir($imageDir, 0777, true);

    $imageName = time() . "_" . basename($_FILES['productImage']['name']);
    $targetImage = $imageDir . $imageName;

    if(!move_uploaded_file($_FILES['productImage']['tmp_name'], $targetImage)){
        echo json_encode(["status"=>"error", "message"=>"Image upload failed"]);
        exit;
    }
}

$stmt = $conn->prepare("INSERT INTO products(productName, description, price, Image) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssds', $productName, $description, $price, $imageName);

if($stmt->execute()){
    echo json_encode(["status" => "success", "message" => "Product added successfully!"]);
}else{
    echo json_encode(["status" => "error", "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
