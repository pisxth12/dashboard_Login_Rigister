<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

// check if admin
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo json_encode([
        "status" => "error",
        "message" => "Unauthorized access. Admin only."
    ]);
    exit;
}

$productId = $_POST['product_id'] ?? '';
if(!$productId){
    echo json_encode(["status"=>"error","message"=>"Product ID required"]);
    exit;
}

if(isset($_FILES['image']) && $_FILES['image']['name']){
    $imageDir = 'product_uploads/';
    if(!is_dir($imageDir)){
        mkdir($imageDir, 0777, true);
    }
    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $targetImage = $imageDir . $imageName;

    if(!move_uploaded_file($_FILES['image']['tmp_name'], $targetImage)){
        echo json_encode(["status"=>"error","message"=>"Image upload failed"]);
        exit;
    }

    // update DB
    $stmt = $conn->prepare("UPDATE products SET image=? WHERE id=?");
    $stmt->bind_param("si", $imageName, $productId);

    if($stmt->execute()){
        echo json_encode([
            "status"=>"success",
            "message"=>"Product image updated successfully"
        ]);
    } else {
        echo json_encode([
            "status"=>"error",
            "message"=>"DB error: ".$stmt->error
        ]);
    }
    $stmt->close();
}
$conn->close();
?>
