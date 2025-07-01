<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
   exit;
}

// Create upload directories if they don't exist
if (!file_exists('uploads/id_verification')) {
    mkdir('uploads/id_verification', 0777, true);
}
if (!file_exists('uploads/gcash_receipts')) {
    mkdir('uploads/gcash_receipts', 0777, true);
}

if(isset($_POST['submit'])){
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
   $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   // Discount logic
   $discount_type = $_POST['discount_type'] ?? '';
   $discount_amount = $_POST['discount_amount'] ?? 0;

   // Default file paths
   $id_verification = '';
   $gcash_receipt = '';
   $order_status = 'pending';
   $has_error = false;

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){
      if($address == ''){
         $message[] = 'Please add your address!';
         $has_error = true;
      }

      // Handle ID verification (for discount)
      if(!empty($discount_type) && isset($_FILES['id_verification'])){
         $id_file = $_FILES['id_verification'];
         if($id_file['error'] == 0){
            $ext = strtolower(pathinfo($id_file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
            if(in_array($ext, $allowed)){
               $id_verification = "uploads/id_verification/{$user_id}_" . time() . '.' . $ext;
               move_uploaded_file($id_file['tmp_name'], $id_verification);
            } else {
               $message[] = 'Invalid ID file format!';
               $has_error = true;
            }
         }
      }

      // Handle GCash receipt upload
      if($method == 'gcash' && isset($_FILES['gcash_receipt'])){
         $receipt_file = $_FILES['gcash_receipt'];
         if($receipt_file['error'] == 0){
            $ext = strtolower(pathinfo($receipt_file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png'];
            if(in_array($ext, $allowed)){
               $gcash_receipt = "uploads/gcash_receipts/{$user_id}_" . time() . '.' . $ext;
               move_uploaded_file($receipt_file['tmp_name'], $gcash_receipt);
            } else {
               $message[] = 'Invalid GCash receipt format!';
               $has_error = true;
            }
         } else {
            $message[] = 'Please upload your GCash receipt!';
            $has_error = true;
         }
      }

      // Determine order status
      if(!$has_error){
         if(!empty($discount_type) && $method == 'gcash'){
            $order_status = 'pending_verification';
         } elseif(!empty($discount_type)){
            $order_status = 'pending_discount_verification';
         } elseif($method == 'gcash'){
            $order_status = 'pending_payment_verification';
         }

         // Insert order
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, discount_type, discount_amount, id_verification, gcash_receipt, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
         $insert_order->execute([
            $user_id, $name, $number, $email, $method, $address, $total_products, $total_price,
            $discount_type, $discount_amount, $id_verification, $gcash_receipt, $order_status
         ]);

         // ✅ Loyalty points logic (₱500 = 1 point)
         $earned_points = floor($total_price / 500);
         if ($earned_points > 0) {
            $update_points = $conn->prepare("UPDATE users SET loyalty_points = loyalty_points + ? WHERE id = ?");
            $update_points->execute([$earned_points, $user_id]);
         }

         // Clear cart
         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         // Success message
         if(in_array($order_status, ['pending_verification', 'pending_discount_verification', 'pending_payment_verification'])){
            $message[] = 'Order placed successfully! Your order is pending admin verification. You earned ' . $earned_points . ' loyalty point(s).';
         } else {
            $message[] = 'Order placed successfully! You earned ' . $earned_points . ' loyalty point(s).';
         }
      }
   } else {
      $message[] = 'Your cart is empty';
   }
}

// Get user profile
$fetch_profile = [];
$get_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$get_profile->execute([$user_id]);
if($get_profile->rowCount() > 0){
   $fetch_profile = $get_profile->fetch(PDO::FETCH_ASSOC);
} else {
   header('location:logout.php');
   exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout - Amazing Silog Restobar</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .discount-section {
         background: #f8f9fa;
         padding: 20px;
         border-radius: 10px;
         margin: 20px 0;
         border: 2px solid #e9ecef;
      }
      
      .discount-section.active {
         border-color: #28a745;
         background: #f8fff9;
      }
      
      .discount-options {
         display: flex;
         gap: 15px;
         margin: 15px 0;
      }
      
      .discount-card {
         flex: 1;
         padding: 15px;
         border: 2px solid #ddd;
         border-radius: 8px;
         cursor: pointer;
         text-align: center;
         transition: all 0.3s ease;
      }
      
      .discount-card:hover {
         border-color: #007bff;
         background: #f0f8ff;
      }
      
      .discount-card.selected {
         border-color: #28a745;
         background: #f8fff9;
      }
      
      .discount-card h4 {
         margin: 0 0 10px 0;
         color: #333;
      }
      
      .discount-card p {
         margin: 0;
         font-size: 14px;
         color: #666;
      }
      
      .file-upload {
         margin: 15px 0;
         display: none;
      }
      
      .file-upload.show {
         display: block;
      }
      
      .file-upload label {
         display: block;
         margin-bottom: 5px;
         font-weight: bold;
         color: #333;
      }
      
      .file-upload input[type="file"] {
         width: 100%;
         padding: 10px;
         border: 2px dashed #ddd;
         border-radius: 5px;
         background: #f9f9f9;
      }
      
      .gcash-info {
         background: #e7f3ff;
         padding: 15px;
         border-radius: 8px;
         margin: 15px 0;
         border-left: 4px solid #007bff;
         display: none;
      }
      
      .gcash-info.show {
         display: block;
      }
      
      .price-breakdown {
         background: #f8f9fa;
         padding: 15px;
         border-radius: 8px;
         margin: 15px 0;
      }
      
      .price-row {
         display: flex;
         justify-content: space-between;
         margin: 5px 0;
      }
      
      .price-row.total {
         font-weight: bold;
         font-size: 18px;
         border-top: 2px solid #ddd;
         padding-top: 10px;
         margin-top: 10px;
      }
      
      .price-row.discount {
         color: #28a745;
         font-weight: bold;
      }
      
      .verification-note {
         background: #fff3cd;
         border: 1px solid #ffeaa7;
         padding: 10px;
         border-radius: 5px;
         margin: 10px 0;
         font-size: 14px;
      }
   </style>
</head>
<body>   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<!-- Display messages -->

<?php
if(isset($message) && is_array($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>



<section class="checkout">
   <h1 class="title">Order Summary</h1>
   
<form action="" method="post" enctype="multipart/form-data" id="checkoutForm">
   <div class="cart-items">
      <h3>Cart Items</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">₱<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">Your cart is empty!</p>';
         }
      ?>
      <a href="cart.php" class="btn">View Cart</a>
   </div>

   <!-- Discount Section -->
   <div class="discount-section" id="discountSection">
      <h3><i class="fas fa-percent"></i> Senior Citizen & PWD Discount</h3>
      <p>Get 20% discount with valid ID verification</p>
      
      <div class="discount-options">
         <div class="discount-card" data-discount="senior">
            <h4><i class="fas fa-user-friends"></i> Senior Citizen</h4>
            <p>20% discount<br>Valid ID required</p>
         </div>
         <div class="discount-card" data-discount="pwd">
            <h4><i class="fas fa-wheelchair"></i> PWD</h4>
            <p>20% discount<br>Valid ID required</p>
         </div>
         <div class="discount-card" data-discount="none">
            <h4><i class="fas fa-times"></i> No Discount</h4>
            <p>Regular pricing</p>
         </div>
      </div>
      
      <div class="file-upload" id="idUpload">
         <label for="id_verification">Upload Valid ID for Verification:</label>
         <input type="file" name="id_verification" id="id_verification" accept=".jpg,.jpeg,.png,.pdf">
         <small>Accepted formats: JPG, PNG, PDF (Max 5MB)</small>
         <div class="verification-note">
            <i class="fas fa-info-circle"></i>
            Your ID will be verified by our staff. Order will be processed after verification.
         </div>
      </div>
   </div>

   <!-- Price Breakdown -->
   <div class="price-breakdown">
      <h3>Price Summary</h3>
      <div class="price-row">
         <span>Subtotal:</span>
         <span id="subtotal">₱<?= $grand_total; ?></span>
      </div>
      <div class="price-row discount" id="discountRow" style="display: none;">
         <span>Discount (20%):</span>
         <span id="discountAmount">-₱0</span>
      </div>
      <div class="price-row total">
         <span>Total:</span>
         <span id="finalTotal">₱<?= $grand_total; ?></span>
      </div>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" id="hiddenTotalPrice" value="<?= $grand_total; ?>">
   <input type="hidden" name="discount_type" id="hiddenDiscountType" value="">
   <input type="hidden" name="discount_amount" id="hiddenDiscountAmount" value="0">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <h3>Your Info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">Update Info</a>
      
      <h3>Delivery Address</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'Please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">Update Address</a>
      
      <h3>Payment Method</h3>
      <select name="method" class="box" required id="paymentMethod">
         <option value="" disabled selected>Select payment method --</option>
         <option value="cash on delivery">Cash on Delivery</option>
         <option value="gcash">GCash</option>
      </select>
      
      <!-- GCash Payment Info -->
      <div class="gcash-info" id="gcashInfo">
         <h4><i class="fab fa-google-pay"></i> GCash Payment Instructions</h4>
         <p><strong>GCash Number:</strong> 09XX-XXX-XXXX</p>
         <p><strong>Account Name:</strong> Amazing Silog Restobar</p>
         <p>1. Send payment to the GCash number above</p>
         <p>2. Take a screenshot of your payment receipt</p>
         <p>3. Upload the receipt below for verification</p>
         
         <div class="file-upload show">
            <label for="gcash_receipt">Upload GCash Payment Receipt:</label>
            <input type="file" name="gcash_receipt" id="gcash_receipt" accept=".jpg,.jpeg,.png">
            <small>Accepted formats: JPG, PNG only (Max 5MB)</small>
         </div>
         
         <div class="verification-note">
            <i class="fas fa-clock"></i>
            Your payment will be verified by our staff. Order will be processed after verification.
         </div>
      </div>
      
      <input type="submit" value="Place Order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white); margin-top: 20px;" name="submit" id="submitBtn">
   </div>
</form>  
</section>

<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const discountCards = document.querySelectorAll('.discount-card');
    const discountSection = document.getElementById('discountSection');
    const idUpload = document.getElementById('idUpload');
    const paymentMethod = document.getElementById('paymentMethod');
    const gcashInfo = document.getElementById('gcashInfo');
    const submitBtn = document.getElementById('submitBtn');
    
    const subtotalAmount = <?= $grand_total; ?>;
    let selectedDiscount = 'none';
    
    // Discount card selection
    discountCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selected class from all cards
            discountCards.forEach(c => c.classList.remove('selected'));
            
            // Add selected class to clicked card
            this.classList.add('selected');
            
            selectedDiscount = this.dataset.discount;
            
            if(selectedDiscount === 'senior' || selectedDiscount === 'pwd') {
                discountSection.classList.add('active');
                idUpload.classList.add('show');
                calculateTotal();
                document.getElementById('hiddenDiscountType').value = selectedDiscount;
            } else {
                discountSection.classList.remove('active');
                idUpload.classList.remove('show');
                calculateTotal();
                document.getElementById('hiddenDiscountType').value = '';
            }
        });
    });
    
    // Payment method change
    paymentMethod.addEventListener('change', function() {
        if(this.value === 'gcash') {
            gcashInfo.classList.add('show');
        } else {
            gcashInfo.classList.remove('show');
        }
    });
    
    // Calculate total with discount
    function calculateTotal() {
        let total = subtotalAmount;
        let discountAmount = 0;
        
        if(selectedDiscount === 'senior' || selectedDiscount === 'pwd') {
            discountAmount = Math.round(subtotalAmount * 0.20);
            total = subtotalAmount - discountAmount;
            
            document.getElementById('discountRow').style.display = 'flex';
            document.getElementById('discountAmount').textContent = '-₱' + discountAmount;
        } else {
            document.getElementById('discountRow').style.display = 'none';
        }
        
        document.getElementById('finalTotal').textContent = '₱' + total;
        document.getElementById('hiddenTotalPrice').value = total;
        document.getElementById('hiddenDiscountAmount').value = discountAmount;
    }
    
    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        const paymentValue = paymentMethod.value;
        const discountType = document.getElementById('hiddenDiscountType').value;
        
        // Check if discount is selected but no ID uploaded
        if((discountType === 'senior' || discountType === 'pwd') && !document.getElementById('id_verification').files[0]) {
            e.preventDefault();
            alert('Please upload your valid ID for discount verification.');
            return;
        }
        
        // Check if GCash is selected but no receipt uploaded
        if(paymentValue === 'gcash' && !document.getElementById('gcash_receipt').files[0]) {
            e.preventDefault();
            alert('Please upload your GCash payment receipt.');
            return;
        }
    });
    
    // File size validation
    function validateFileSize(input, maxSize = 5) {
        const file = input.files[0];
        if(file && file.size > maxSize * 1024 * 1024) {
            alert('File size must be less than ' + maxSize + 'MB');
            input.value = '';
        }
    }
    
    document.getElementById('id_verification').addEventListener('change', function() {
        validateFileSize(this);
    });
    
    document.getElementById('gcash_receipt').addEventListener('change', function() {
        validateFileSize(this);
    });
});
</script>

<!-- custom js file link  -->
<script src="js/script.js"></script>
</body>
</html>