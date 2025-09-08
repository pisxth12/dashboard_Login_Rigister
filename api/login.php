<?php
    session_start();
    header('Content-Type: application/json');
    include 'db.php';

    if($_SERVER['REQUEST_METHOD']  !== "POST"){
        echo json_encode([
            'status'=>'error',
            'message'=>'Request methode errror'
        ]);
        exit;
    }

    $email  = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(empty($email) && empty($password)){
        echo json_encode([
            'status'=>'error',
            'message'=>'Please input data'
        ]);
        exit;
    }

    $stmt = $conn->prepare("SELECT id , username , email , password , image , role FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param('s', $email);
    if(!$stmt->execute()){
        echo json_encode([
            "status"=>"error",
            "message"=>"Query faile"
        ]);
        exit;
    }

    $result = $stmt->get_result();
    if($result->num_rows===1){
        $row = $result->fetch_assoc();
        if(password_verify($password , $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            echo json_encode([
                "status"=>"success",
                "message"=>"select row succes",
                "username"=> $row['username'],
                "image"=> $row["image"],
                "role"=> $row['role']

            ]);
        }else{
            echo json_encode([
                'status'=> 'error',
                'message'=>'invalid password'
            ]);
        }

    }else{
        echo json_encode([
            'status'=> 'error',
            'message'=>'email not found'
        ]);
    }
    $stmt->close();
    $conn->close();

?>