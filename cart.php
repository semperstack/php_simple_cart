<?php
/**
 * User: Andrew Maris
 * Semperstack.com
 */
require_once('db.php');
require_once('core.php');
if(isset($_GET['add']) && !empty($_GET['add'])) {
$products = new Product();
$quantity = $products->getById($db,$_GET['add'])->quantity;
$id = $products->getById($db,$_GET['add'])->id;

   if($quantity!=$_SESSION['cart_'.$_GET['add']]) {
       $_SESSION['cart_'.$_GET['add']]+=1;
       header("Location: index.php");
   }


}
if(isset($_GET['remove']) && !empty($_GET['remove'])) {
    $_SESSION['cart_'.(int)$_GET['remove']]--;
    header("Location: index.php");
}
if(isset($_GET['delete']) && !empty($_GET['delete'])) {
    $_SESSION['cart_'.(int)$_GET['delete']]=0;
    header("Location: index.php");
}

header('Location: index.php');