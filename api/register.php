<?php
session_start();
header('Content-Type: application/json');
include 'db.php'; 


$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm'] ?? '';

if(empty($username) || empty($email) || empty($password) || empty($confirm)){
    echo json_encode(["status"=>"error","message"=>"All fields are required"]);
    exit;
}


if($password !== $confirm){
    echo json_encode(["status"=>"error","message"=>"Passwords do not match"]);
    exit;
}

if(isset($_FILES['image']) && $_FILES['image']['name']){
    $imageDir = 'upload/';
    if(!is_dir($imageDir)){
        mkdir($imageDir , 0777 , true);
    }
    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $targetImage = $imageDir . $imageName;

    if(!move_uploaded_file($_FILES['image']['tmp_name'],$targetImage)){
        echo json_encode([
            "status"=>"error",
            "message"=>"Image uploaded fail"
        ]);
        exit;
    }
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Image have not selected"
    ]);
    exit;
}

// $allowTypes = ["image/jpg","image/png" , "image/gif","image/jpg","image/webp","image/JPG"];
// if(!in_array($_FILES['image']['type'],$allowTypes)){
//      echo json_encode(["status"=>"error","message"=>"Invalid image type"]);
//     exit;
// }
if($_FILES['image']['size'] > 2*1024*1024){
    echo json_encode(["status"=>"error","message"=>"Image too large"]);
    exit;

}


$check = $conn->prepare("SELECT id FROM users WHERE email=? LIMIT 1"); 
$check->bind_param('s', $email);
$check->execute();
$check->store_result();
if($check->num_rows>0){
    echo json_encode(["status"=>"error","message"=>"Email already exists"]);
    exit;
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (username,email,password,image) VALUES (?,?,?,?)");
$stmt->bind_param("ssss",$username,$email,$hashedPassword,$imageName);

if($stmt->execute()){
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    echo json_encode([
        "status"=>"success",
        "username"=>$username,
        "image"=>$imageName
    ]);
} else {
    echo json_encode(["status"=>"error","message"=>"Database error: ".$stmt->error]);
}

$stmt->close();
$conn->close();
?>
