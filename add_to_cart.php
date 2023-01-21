<?php

session_start();
require 'config/config.php';
if ($_POST) {

    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($qty > $result['quantity']) 
    {
       echo "<script>alert('product quantity has reached out of limit');window.location.href='product_detail.php?id=$id';</script>";
    }
    else{
        if (isset($_SESSION['cart']))
    {
        $_SESSION['cart']['id='.$id] += $qty; // id=1 -> 10+next+next
    }else
    {
        $_SESSION['cart']['id='.$id] = $qty; // id=1 -> 10
    }
    header("Location:product_detail.php?id=".$id);
    }

    

}





?>