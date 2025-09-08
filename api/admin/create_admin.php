<?php
include 'db.php';

$username = "Sorn Piseth";
$email = "seth.dev.1100@gmail.com";
$password = "Pisethlove12";
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$image = "./profile/admin.jpg";
$role = "admin";

$conn->query("DELETE FROM users WHERE email='$email'");


$stmt = $conn->prepare("INSERT INTO users (username, email, password, image, role) VALUES (?,?,?,?,?)");
$stmt->bind_param('sssss', $username, $email, $hashedPassword, $image, $role);

if($stmt->execute()){
    echo "Admin account created successfully";
} else {
    echo "Error: ".$stmt->error;
}

$stmt->close();
$conn->close();
?>

