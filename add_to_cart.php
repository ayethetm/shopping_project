<?php

session_start();
require 'config/common.php';
require 'config/config.php';



if ($_POST) {
    
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $stmt = $pdo->prepare("SELECT quantity FROM products WHERE id=".$id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    if ($qty > $result) 
    {
       echo "<script>alert('product quantity has reached out of limit');</script>";
    }

    if (isset($_SESSION['cart']['id='. $id])) 
    {
        $qty += $qty; // id=1 -> 10+next+next
    }

}

header("Location:product_detail.php?id=".$id);



?>