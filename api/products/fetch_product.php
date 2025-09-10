<?php
include 'db.php';

$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['image_url'] = !empty($row['image'])
            ? 'http://localhost/dashboard/api/products/uploads/' . $row['image']
            : 'http://localhost/dashboard/api/products/uploads/placeholder.png';

        $products[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($products);

$conn->close();
?>
