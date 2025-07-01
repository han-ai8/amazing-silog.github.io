<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
 

</head>
<style>
.footer{
   padding-top: 60px;
}
.footer .grid{
   display: grid;
   grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
   gap: 10px;
   padding: 20px;
}

.footer .grid .box{
   background: #fff;
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
   text-align: center;
   text-decoration: none;
   transition: transform 0.3s ease, box-shadow 0.3s ease;
   padding: 20px;
   display: flex;
   flex-direction: column;
   align-items: center;
}

.footer .grid .box img{
   height: 10rem;
   width: 100%;
   object-fit: contain;
   margin-bottom: .5rem;
}

.footer .grid .box:hover{
   transform: translateY(-5px);
   box-shadow: 0 8px 16px rgba(255, 174, 0, 0.384);
}

.footer .grid .box h3{
   margin:1rem 0;
   font-size: 2rem;
   color:var(--black);
   text-transform: capitalize;
}

.footer .grid .box p,
.footer .grid .box a{
   display: block;
   font-size: 1.7rem;
   color:var(--light-color);
   line-height: 1.8;
}

.credit{
   padding:3rem 2rem;
   text-align: center;
   background-color: var(--black);
   color:var(--white);
   font-size: 2rem;
   text-transform: capitalize;
   /* padding-bottom: 10rem; */
}

.credit span{
   color:var(--yellow);
}

.loader{
   position: fixed;
   top:0; left:0; right:0; bottom: 0;
   z-index: 1000000;
   background-color: var(--white);
   display: flex;
   align-items: center;
   justify-content: center;
}

.loader img{
   height: 25rem;
}
.orders .box-container{
   display: flex;
   flex-wrap: wrap;
   gap:1.5rem;
   align-items: flex-start;
}
.box-container:hover{
   background-color: #fed330;
}

.orders .box-container .box{
   padding:1rem 2rem;
   border:var(--border);
   flex:1 1 40rem;
}

.orders .box-container .box p{
   line-height: 1.5;
   margin:1rem 0;
   font-size: 2rem;
   color:var(--light-color);
}

.orders .box-container .box p span{
   color:var(--black);
}


 
 /* Responsive */
@media (max-width: 768px) {
   .footer-container {
     flex-direction: column;
     text-align: center;
   }
 
   .social-icons {
     justify-content: center;
   }
}
</style>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->



<section class="orders">

   <h1 class="title">Your orders</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<a href="login.php" class="empty">please login to see your orders</a>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
         
   ?>
   <div class="box">
      <p>Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Total price : <span>₱<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>Payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
      }
   ?>

   </div>


</section>










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>