<?php
session_start();
include 'db.php';

$sql = "SELECT productName , price , description , image FROM products ORDER BY id DESC";

$result = $conn->query($sql);

$products = [];
while($row = $result->fetch_assoc()){
    $products[] = [
        "productName"=> $row["productName"],
        "price"=>$row['price'],
        "description"=> $row['description'],
        "image_url"=> !empty($row['image']) ? "http://localhost/dashboards/api/admin/productImage/" . $row['image']  : "http://localhost/dashboards/assets/no-image.png"

    ];
}
echo json_encode($products);
?>