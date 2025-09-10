<?php
    $db_name = "dashboard";
    $conn = new mysqli("localhost" , "root" , "" , $db_name );

    if($conn->connect_error){
        die("Connetio to database failed");
     
    }

    $conn->set_charset("utf8");

?>