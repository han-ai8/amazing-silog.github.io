<?php

if (isset($_POST['add_to_cart']) && isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
   $product_id = $_POST['pid'];
   $qty = $_POST['qty'];
   $name = $_POST['name'];
   $price = $_POST['price'];
   $image = $_POST['image'];

   // check if already in cart
   $check_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND pid = ?");
   $check_cart->execute([$user_id, $product_id]);

   if ($check_cart->rowCount() > 0) {
      $message[] = 'already added to cart!';
   } else {
      $insert_cart = $conn->prepare("INSERT INTO cart(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $product_id, $name, $price, $qty, $image]);
      $message[] = 'added to cart!';
   }
}

?>
