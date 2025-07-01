<?php
include 'components/connect.php';
session_start();
if(isset($_POST['buy_now'])){
   $product_id = $_POST['pid'];
   $qty = $_POST['qty'];

   // You can choose to store this in session and redirect to checkout page
   $_SESSION['buy_now'] = [
      'pid' => $product_id,
      'qty' => $qty
   ];
   header("Location: checkout.php");
   exit;
}

include 'components/add_cart.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">
</head>

<style>
   .animate-slide {
      animation: fadeInUp 1s ease forwards;
      opacity: 0;
   }
   
   .swiper-slide-active .animate-slide {
      animation: fadeInUp 1s ease forwards;
   }
   
   @keyframes fadeInUp {
      from {
         opacity: 0;
         transform: translateY(20px);
      }
      to {
         opacity: 1;
         transform: translateY(0);
      }
   }
   .swiper-wrapper {
   display: flex;
   width: 100%;
   transition: transform 0.4s ease;
}

.swiper-slide {
   min-width: 100%;
   box-sizing: border-box;
}

.swiper-button-next, .swiper-button-prev {
   position: absolute;
   top: 50%;
   transform: translateY(-50%);
   z-index: 10;
   cursor: pointer;
   font-size: 2rem;
   color: #fff;
   background: rgba(0,0,0,0.4);
   padding: 0.5rem 1rem;
   border-radius: 50%;
   user-select: none;
}

.swiper-button-next {
   right: 10px;
}

.swiper-button-prev {
   left: 10px;
}



   /* You may want to ensure Swiper buttons are visible */
   .swiper-button-next, .swiper-button-prev {
      color: #fff;
   }
</style>

<body>
<?php include 'components/user_header.php'; ?>
<!-- Hero slider-->
<section class="hero" id="home"> 
   <div class="swiper hero-slider" >
      <div class="swiper-wrapper">
         <div class="swiper-slide slide">
            <div class="content animate-slide">
               <span>Best Seller</span>
               <h3>Pork Sisig</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="project-images/sisig.png" alt="">
            </div>
         </div>
        
         <div class="swiper-slide slide">
            <div class="content animate-slide">
               <span>Best Seller</span>
               <h3>Crispy Pata</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="project-images/crispy.png" alt="">
            </div>
         </div>
         
         <div class="swiper-slide slide">
            <div class="content animate-slide">
               <span>Best Seller</span>
               <h3>Bulalo</h3>
               <a href="menu.php" class="btn">see menus</a>
            </div>
            <div class="image">
               <img src="project-images/bulalo.png" alt="">
            </div>
         </div>
        
      </div>
      
      <!-- Add Pagination and Navigation -->
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
     
   </div>
   
</section>

<section class="category">
   <h1 class="title">CATEGORY</h1>
   <div class="box-container">
      <a href="category.php?category=SILOG MEALS" class="box">
         <img src="images/cutlery.png" alt="">
         <h3>AMAZING SILOG MEALS</h3>
      </a>
      <a href="category.php?category=PARES" class="box">
         <img src="images/rice.png" alt="">
         <h3>I ♥ PARES</h3>
      </a>
      <a href="category.php?category=SOUP" class="box">
         <img src="images/soup.png" alt="">
         <h3>AMAZING PA-SOUP SA PALAYOK</h3>
      </a>
      <a href="category.php?category=SISIG BUNDLES" class="box">
         <img src="images/platter.png" alt="">
         <h3>AMAZING SISIG BUNDLES</h3>
      </a>
      <a href="category.php?category=ALA CARTE" class="box">
         <img src="images/platter (1).png" alt="">
         <h3>AMAZING ALA CARTE</h3>
      </a>
      <a href="category.php?category=SNACKS" class="box">
         <img src="images/SNACKS.png" alt="">
         <h3>AMAZING SNACKS</h3>
      </a>
      <a href="category.php?category=PASTA" class="box">
         <img src="images/spaghetti.png" alt="">
         <h3>AMAZING PASTA</h3>
      </a>
      <a href="category.php?category=SIZZLINGS" class="box">
         <img src="images/barbecue-eating.png" alt="">
         <h3>AMAZING SIZZLINGS</h3>
      </a>
      <a href="category.php?category=DRINKS" class="box">
         <img src="images/orange-juice.png" alt="">
         <h3>DRINKS</h3>
      </a>
      <a href="category.php?category=ADD-ONS" class="box">
         <img src="images/extras.png" alt="">
         <h3>EXTRAS</h3>
      </a>
   </div>
</section>
<section class="products">
   <h1 class="title">MENU</h1>
   <div class="box-container">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
         <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
         <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
         <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
        <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
<?php if ($user_id != ''): ?>
   <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
<?php else: ?>
   <a href="login.php" onclick="return confirm('Please login first!')" class="fas fa-shopping-cart"></a>
<?php endif; ?>
         <?php
   $img_path = 'uploaded_img/' . $fetch_products['image'];
   if(file_exists($img_path)){
      echo "<img src='$img_path' alt=''>";
   } else {
      echo "<img src='images/placeholder.png' alt='No image'>";
   }
?>
         <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
         <div class="name"><?= $fetch_products['name']; ?></div>
         <div class="flex">
            <div class="price"><span>₱</span><?= $fetch_products['price']; ?></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
         </div>
      </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>
   </div>
   <div class="more-btn">
      <a href="menu.php" class="btn">view all</a>
   </div>
</section>

<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
   const sliderWrapper = document.querySelector(".swiper-wrapper");
   const slides = document.querySelectorAll(".swiper-slide");
   const nextBtn = document.querySelector(".swiper-button-next");
   const prevBtn = document.querySelector(".swiper-button-prev");

   let currentIndex = 0;
   let isOnline = navigator.onLine;
   let autoplayInterval;

   function updateSlidePosition() {
      const offset = -currentIndex * 100;
      sliderWrapper.style.transform = `translateX(${offset}%)`;
      sliderWrapper.style.transition = "transform 0.4s ease";
   }

   function goNext() {
      currentIndex = (currentIndex + 1) % slides.length;
      updateSlidePosition();
   }

   function goPrev() {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateSlidePosition();
   }

   nextBtn.addEventListener("click", goNext);
   prevBtn.addEventListener("click", goPrev);

   // Autoplay when online
   if (isOnline) {
      autoplayInterval = setInterval(goNext, 3000);
   }

   // Reload when going online/offline to recheck autoplay
   window.addEventListener("online", () => location.reload());
   window.addEventListener("offline", () => location.reload());

   // Initial position
   updateSlidePosition();
});
</script>


</body>
</html>
