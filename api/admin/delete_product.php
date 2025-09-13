<?php
include 'db.php';

$productName = $_POST['productName'] ?? '';

if($productName){
    $stmt = $conn->prepare("DELETE FROM products WHERE productName=?");
    $stmt->bind_param("s", $productName);
    if($stmt->execute()){
        echo json_encode(["status"=>"success","message"=>"Product deleted successfully!"]);
    } else {
        echo json_encode(["status"=>"error","message"=>"Failed to delete product"]);
    }
    $stmt->close();
} else {
    echo json_encode(["status"=>"error","message"=>"No product specified"]);
}

$conn->close();
?>
