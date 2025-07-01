<?php

if (file_exists('../components/connect.php')) {
    include '../components/connect.php';
} elseif (file_exists('components/connect.php')) {
    include 'components/connect.php';
} else {
    die('Error: Database connection file not found. Please check the path to components/connect.php');
}
session_start();
// Check if admin is logged in
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
   exit();
}

$message = [];

if (!isset($conn)) {
    die('Error: Database connection not established. Please check your connect.php file.');
}

if(isset($_POST['verification_action'])){
   $order_id = $_POST['order_id'];
   $action = $_POST['verification_action'];

   try {
       if($action == 'approve_discount'){
          $update_order = $conn->prepare("UPDATE `orders` SET `status` = 'discount_approved' WHERE `id` = ?");
          $update_order->execute([$order_id]);
          $message[] = 'Discount approved successfully!';
       }
       elseif($action == 'reject_discount'){
          // Reset discount and recalculate total
          $select_order = $conn->prepare("SELECT * FROM `orders` WHERE `id` = ?");
          $select_order->execute([$order_id]);
          $order = $select_order->fetch(PDO::FETCH_ASSOC);
          
          if($order) {
              $original_total = $order['total_price'] + $order['discount_amount'];
              
              $update_order = $conn->prepare("UPDATE `orders` SET `status` = 'discount_rejected', `discount_type` = NULL, `discount_amount` = 0, `total_price` = ? WHERE `id` = ?");
              $update_order->execute([$original_total, $order_id]);
              $message[] = 'Discount rejected. Order total updated.';
          } else {
              $message[] = 'Error: Order not found.';
          }
       }
       elseif($action == 'approve_payment'){
          $update_order = $conn->prepare("UPDATE `orders` SET `status` = 'payment_verified' WHERE `id` = ?");
          $update_order->execute([$order_id]);
          $message[] = 'Payment verified successfully!';
       }
       elseif($action == 'reject_payment'){
          $update_order = $conn->prepare("UPDATE `orders` SET `status` = 'payment_rejected' WHERE `id` = ?");
          $update_order->execute([$order_id]);
          $message[] = 'Payment rejected.';
       }
       elseif($action == 'approve_both'){
          $update_order = $conn->prepare("UPDATE `orders` SET `status` = 'completed' WHERE `id` = ?");
          $update_order->execute([$order_id]);
          $message[] = 'Order approved and completed!';
       }
   } catch(PDOException $e) {
       $message[] = 'Database error: ' . $e->getMessage();
   }
}

// Handle regular order status updates (from place_orders.php)
if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   try {
       $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
       $update_status->execute([$payment_status, $order_id]);
       $message[] = 'Payment status updated!';
   } catch(PDOException $e) {
       $message[] = 'Database error: ' . $e->getMessage();
   }
}

// Handle order deletion
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   try {
       $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
       $delete_order->execute([$delete_id]);
       $message[] = 'Order deleted successfully!';
   } catch(PDOException $e) {
       $message[] = 'Error deleting order: ' . $e->getMessage();
   }
}

// Get current view from URL parameter
$view = isset($_GET['view']) ? $_GET['view'] : 'all';

// Function to check if image file exists and return proper path
function getImagePath($imagePath) {
    if (empty($imagePath)) return null;
    
    // Remove any leading slashes or dots
    $cleanPath = ltrim($imagePath, './');
    
    // Try different possible paths
    $possiblePaths = [
        $imagePath,                    // Original path
        '../' . $cleanPath,           // Parent directory
        './' . $cleanPath,            // Current directory
        $cleanPath,                   // Clean path
        '../uploaded_img/' . basename($imagePath), // Standard upload folder
        'uploaded_img/' . basename($imagePath)     // Upload folder in current dir
    ];
    
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            return $path;
        }
    }
    
    return $imagePath; // Return original if no valid path found
}

// Fetch orders based on view
try {
    if($view == 'verification') {
        // Orders requiring verification
        $select_orders = $conn->prepare("SELECT o.*, u.name as customer_name FROM `orders` o 
                                       LEFT JOIN `users` u ON o.user_id = u.id 
                                       WHERE o.status IN ('pending_discount_verification', 'pending_payment_verification', 'pending_verification') 
                                       ORDER BY o.placed_on DESC");
    } else {
        // All orders
        $select_orders = $conn->prepare("SELECT o.*, u.name as customer_name FROM `orders` o 
                                       LEFT JOIN `users` u ON o.user_id = u.id 
                                       ORDER BY o.placed_on DESC");
    }
    $select_orders->execute();
} catch(PDOException $e) {
    die('Database error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Management - Admin Panel</title>
   
   <!-- Font Awesome CDN -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   
   <!-- Custom Admin CSS -->
   <link rel="stylesheet" href="../css/admin_style.css">
   
   <!-- Additional styles for order management -->
   <style>
      .order-management {
         padding: 2rem 0;
      }
      
      .nav-tabs {
         display: flex;
         gap: 1rem;
         margin-bottom: 2rem;
         justify-content: center;
         flex-wrap: wrap;
      }
      
      .nav-tab {
         padding: 1rem 2rem;
         background-color: var(--main-color);
         color: var(--black);
         text-decoration: none;
         border-radius: .5rem;
         border: var(--border);
         font-size: 1.6rem;
         transition: all 0.3s ease;
      }
      
      .nav-tab:hover, .nav-tab.active {
         transform: translateY(-5px);
         box-shadow: var(--box-shadow);
         background-color: var(--orange);
      }
      
      .order-card {
         background-color: var(--white);
         border: var(--border);
         border-radius: .5rem;
         box-shadow: var(--box-shadow);
         margin-bottom: 2rem;
         overflow: hidden;
      }
      
      .order-header {
         background-color: var(--main-color);
         padding: 1.5rem 2rem;
         border-bottom: var(--border);
      }
      
      .order-header h3 {
         font-size: 2.2rem;
         color: var(--black);
         margin-bottom: .5rem;
      }
      
      .order-header small {
         font-size: 1.4rem;
         color: var(--light-color);
      }
      
      .order-body {
         padding: 2rem;
      }
      
      .order-details {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
         gap: 2rem;
         margin-bottom: 2rem;
      }
      
      .detail-group h4 {
         font-size: 1.8rem;
         color: var(--black);
         margin-bottom: 1rem;
         padding-bottom: .5rem;
         border-bottom: 2px solid var(--main-color);
      }
      
      .detail-item {
         margin: .8rem 0;
         font-size: 1.6rem;
         color: var(--black);
      }
      
      .detail-item strong {
         color: var(--orange);
      }
      
      .verification-section {
         border: 2px solid var(--main-color);
         border-radius: .5rem;
         padding: 1.5rem;
         margin: 1.5rem 0;
         background-color: var(--light-bg);
      }
      
      .verification-section.discount {
         border-color: #27ae60;
         background-color: #f8fff9;
      }
      
      .verification-section.payment {
         border-color: var(--orange);
         background-color: #fff8f0;
      }
      
      .verification-section h4 {
         font-size: 1.8rem;
         color: var(--black);
         margin-bottom: 1rem;
      }
      
      .file-preview {
         margin: 1rem 0;
      }
      
      .file-preview img {
         max-width: 20rem;
         max-height: 20rem;
         border: var(--border);
         border-radius: .5rem;
         cursor: pointer;
         transition: transform 0.3s ease;
      }
      
      .file-preview img:hover {
         transform: scale(1.05);
      }
      
      .file-preview .error-msg {
         color: #dc3545;
         font-style: italic;
         padding: 10px;
         background: #f8d7da;
         border: 1px solid #f5c6cb;
         border-radius: 4px;
         margin-top: 5px;
      }
      
      .file-preview .image-info {
         font-size: 1.2rem;
         color: var(--light-color);
         margin-top: 5px;
      }
      
      .action-buttons {
         display: flex;
         gap: 1rem;
         margin-top: 1.5rem;
         flex-wrap: wrap;
      }
      
      .status-badge {
         padding: .5rem 1rem;
         border-radius: 1.5rem;
         font-size: 1.2rem;
         font-weight: bold;
         margin-left: 1rem;
         display: inline-block;
      }
      
      .status-pending { 
         background-color: var(--main-color); 
         color: var(--black); 
      }
      
      .status-completed { 
         background-color: #27ae60; 
         color: var(--white); 
      }
      
      .status-verification { 
         background-color: var(--orange); 
         color: var(--white); 
      }
      
      .status-rejected { 
         background-color: var(--red); 
         color: var(--white); 
      }
      
      .no-orders {
         text-align: center;
         padding: 4rem;
         color: var(--light-color);
      }
      
      .no-orders i {
         font-size: 6rem;
         color: var(--main-color);
         margin-bottom: 2rem;
      }
      
      .no-orders h3 {
         font-size: 2.5rem;
         color: var(--black);
         margin-bottom: 1rem;
      }
      
      .modal {
         display: none;
         position: fixed;
         z-index: 1000;
         left: 0;
         top: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(0,0,0,0.8);
      }
      
      .modal-content {
         background-color: var(--white);
         margin: 5% auto;
         padding: 2rem;
         border: var(--border);
         border-radius: .5rem;
         width: 80%;
         max-width: 50rem;
         position: relative;
      }
      
      .close {
         color: var(--light-color);
         float: right;
         font-size: 2.8rem;
         font-weight: bold;
         cursor: pointer;
         position: absolute;
         top: 1rem;
         right: 1.5rem;
      }
      
      .close:hover {
         color: var(--black);
      }
      
      .order-header-flex {
         display: flex;
         justify-content: space-between;
         align-items: center;
         flex-wrap: wrap;
      }
      
      @media (max-width: 768px) {
         .order-details {
            grid-template-columns: 1fr;
         }
         
         .nav-tabs {
            flex-direction: column;
            align-items: center;
         }
         
         .action-buttons {
            flex-direction: column;
         }
         
         .order-header-flex {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
         }
      }
   </style>
</head>
<body>
   <?php 
   // Include admin header if it exists
   if(file_exists('../components/admin_header.php')) {
       include '../components/admin_header.php';
   }
   ?>

   <section class="order-management">
      <h1 class="heading">Order Management System</h1>
      
      <div class="nav-tabs">
         <a href="?view=all" class="nav-tab <?= $view == 'all' ? 'active' : '' ?>">
            <i class="fas fa-list"></i> All Orders
         </a>
         <a href="?view=verification" class="nav-tab <?= $view == 'verification' ? 'active' : '' ?>">
            <i class="fas fa-clipboard-check"></i> Verification Queue
         </a>
      </div>

      <!-- Display messages -->
      <?php
      if(isset($message) && is_array($message) && count($message) > 0){
         foreach($message as $msg){
            echo '<div class="message">';
            echo '<span>'.$msg.'</span>';
            echo '<i class="fas fa-times" onclick="this.parentElement.remove();"></i>';
            echo '</div>';
         }
      }
      ?>

      <?php if($select_orders->rowCount() > 0): ?>
         <?php while($order = $select_orders->fetch(PDO::FETCH_ASSOC)): ?>
            <div class="order-card">
               <div class="order-header">
                  <div class="order-header-flex">
                     <div>
                        <h3>Order #<?= htmlspecialchars($order['id']); ?></h3>
                        <small>Placed on: <?= date('M d, Y', strtotime($order['placed_on'])); ?></small>
                     </div>
                     <div>
                        <?php
                        $status_class = 'status-pending';
                        if(strpos($order['status'], 'completed') !== false) $status_class = 'status-completed';
                        elseif(strpos($order['status'], 'verification') !== false) $status_class = 'status-verification';
                        elseif(strpos($order['status'], 'rejected') !== false) $status_class = 'status-rejected';
                        ?>
                        <span class="status-badge <?= $status_class ?>"><?= ucwords(str_replace('_', ' ', htmlspecialchars($order['status'] ?? $order['payment_status']))); ?></span>
                     </div>
                  </div>
               </div>
               
               <div class="order-body">
                  <div class="order-details">
                     <div class="detail-group">
                        <h4><i class="fas fa-user"></i> Customer Information</h4>
                        <div class="detail-item"><strong>User ID:</strong> <?= htmlspecialchars($order['user_id']); ?></div>
                        <div class="detail-item"><strong>Name:</strong> <?= htmlspecialchars($order['customer_name'] ?? $order['name']); ?></div>
                        <div class="detail-item"><strong>Email:</strong> <?= htmlspecialchars($order['email']); ?></div>
                        <div class="detail-item"><strong>Phone:</strong> <?= htmlspecialchars($order['number']); ?></div>
                        <div class="detail-item"><strong>Address:</strong> <?= htmlspecialchars($order['address']); ?></div>
                     </div>
                     
                     <div class="detail-group">
                        <h4><i class="fas fa-shopping-cart"></i> Order Information</h4>
                        <div class="detail-item"><strong>Items:</strong> <?= htmlspecialchars($order['total_products']); ?></div>
                        <div class="detail-item"><strong>Payment Method:</strong> <?= ucwords(htmlspecialchars($order['method'])); ?></div>
                        <?php if(isset($order['discount_type']) && $order['discount_type']): ?>
                           <div class="detail-item"><strong>Original Total:</strong> ₱<?= number_format($order['total_price'] + ($order['discount_amount'] ?? 0), 2); ?></div>
                           <div class="detail-item" style="color: #27ae60;"><strong>Discount:</strong> -₱<?= number_format($order['discount_amount'] ?? 0, 2); ?></div>
                        <?php endif; ?>
                        <div class="detail-item"><strong>Final Total:</strong> ₱<?= number_format($order['total_price'], 2); ?></div>
                     </div>
                  </div>

                  <!-- Verification Sections (only show for orders requiring verification) -->
                  <?php if($view == 'verification' || (isset($order['status']) && strpos($order['status'], 'verification') !== false)): ?>
                     
                     <!-- Discount Verification Section -->
                     <?php if(isset($order['discount_type']) && $order['discount_type'] && isset($order['id_verification']) && $order['id_verification']): ?>
                        <div class="verification-section discount">
                           <h4><i class="fas fa-percent"></i> <?= ucwords(htmlspecialchars($order['discount_type'])); ?> Discount Verification</h4>
                           <p class="detail-item"><strong>Discount Type:</strong> <?= ucwords(htmlspecialchars($order['discount_type'])); ?> (20% discount)</p>
                           <p class="detail-item"><strong>Discount Amount:</strong> ₱<?= number_format($order['discount_amount'] ?? 0, 2); ?></p>
                           
                           <div class="file-preview">
                              <p class="detail-item"><strong>Uploaded ID:</strong></p>
                              <?php 
                              $id_verification_path = getImagePath($order['id_verification']);
                              $file_ext = pathinfo($order['id_verification'], PATHINFO_EXTENSION);
                              
                              if(file_exists($id_verification_path) && in_array(strtolower($file_ext), ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                 <img src="<?= htmlspecialchars($id_verification_path); ?>" 
                                      alt="ID Verification" 
                                      onclick="openModal('<?= htmlspecialchars($id_verification_path); ?>')"
                                      onerror="this.parentElement.innerHTML = '<div class=\'error-msg\'>Image not found: <?= htmlspecialchars($order['id_verification']); ?></div>'">
                                 <div class="image-info">Path: <?= htmlspecialchars($id_verification_path); ?></div>
                              <?php elseif(file_exists($id_verification_path) && strtolower($file_ext) == 'pdf'): ?>
                                 <a href="<?= htmlspecialchars($id_verification_path); ?>" target="_blank" class="btn">
                                    <i class="fas fa-file-pdf"></i> View PDF
                                 </a>
                                 <div class="image-info">Path: <?= htmlspecialchars($id_verification_path); ?></div>
                              <?php else: ?>
                                 <div class="error-msg">
                                    File not found or invalid format.<br>
                                    Original path: <?= htmlspecialchars($order['id_verification']); ?><br>
                                    Attempted path: <?= htmlspecialchars($id_verification_path); ?>
                                 </div>
                              <?php endif; ?>
                           </div>
                           
                           <div class="action-buttons">
                              <form method="post" style="display: inline;">
                                 <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">
                                 <button type="submit" name="verification_action" value="approve_discount" class="btn">
                                    <i class="fas fa-check"></i> Approve Discount
                                 </button>
                              </form>
                              <form method="post" style="display: inline;">
                                 <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">
                                 <button type="submit" name="verification_action" value="reject_discount" class="delete-btn">
                                    <i class="fas fa-times"></i> Reject Discount
                                 </button>
                              </form>
                           </div>
                        </div>
                     <?php endif; ?>

                     <!-- Payment Verification Section -->
                     <?php if($order['method'] == 'gcash' && isset($order['gcash_receipt']) && $order['gcash_receipt']): ?>
                        <div class="verification-section payment">
                           <h4><i class="fab fa-google-pay"></i> GCash Payment Verification</h4>
                           <p class="detail-item"><strong>Payment Method:</strong> GCash</p>
                           <p class="detail-item"><strong>Amount:</strong> ₱<?= number_format($order['total_price'], 2); ?></p>
                           
                           <div class="file-preview">
                              <p class="detail-item"><strong>Payment Receipt:</strong></p>
                              <?php 
                              $gcash_receipt_path = getImagePath($order['gcash_receipt']);
                              
                              if(file_exists($gcash_receipt_path)): ?>
                                 <img src="<?= htmlspecialchars($gcash_receipt_path); ?>" 
                                      alt="GCash Receipt" 
                                      onclick="openModal('<?= htmlspecialchars($gcash_receipt_path); ?>')"
                                      onerror="this.parentElement.innerHTML = '<div class=\'error-msg\'>Image not found: <?= htmlspecialchars($order['gcash_receipt']); ?></div>'">
                                 <div class="image-info">Path: <?= htmlspecialchars($gcash_receipt_path); ?></div>
                              <?php else: ?>
                                 <div class="error-msg">
                                    Receipt image not found.<br>
                                    Original path: <?= htmlspecialchars($order['gcash_receipt']); ?><br>
                                    Attempted path: <?= htmlspecialchars($gcash_receipt_path); ?>
                                 </div>
                              <?php endif; ?>
                           </div>
                           
                           <div class="action-buttons">
                              <form method="post" style="display: inline;">
                                 <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">
                                 <button type="submit" name="verification_action" value="approve_payment" class="btn">
                                    <i class="fas fa-check"></i> Verify Payment
                                 </button>
                              </form>
                              <form method="post" style="display: inline;">
                                 <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">
                                 <button type="submit" name="verification_action" value="reject_payment" class="delete-btn">
                                    <i class="fas fa-times"></i> Reject Payment
                                 </button>
                              </form>
                           </div>
                        </div>
                     <?php endif; ?>

                     <!-- Combined Approval -->
                     <?php if(isset($order['discount_type']) && $order['discount_type'] && $order['method'] == 'gcash'): ?>
                        <div class="verification-section" style="border-color: #27ae60; background: #f8fff9;">
                           <h4><i class="fas fa-check-double"></i> Complete Order Approval</h4>
                           <p class="detail-item">This order requires both discount and payment verification.</p>
                           
                           <div class="action-buttons">
                              <form method="post" style="display: inline;">
                                 <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">
                                 <button type="submit" name="verification_action" value="approve_both" class="btn">
                                    <i class="fas fa-check-double"></i> Approve Both & Complete Order
                                 </button>
                              </form>
                           </div>
                        </div>
                     <?php endif; ?>

                  <?php endif; ?>

                  <!-- Regular Order Management Section -->
                  <div class="verification-section">
                     <h4><i class="fas fa-cog"></i>Order Management</h4>
                     <form method="post">
                        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']); ?>">
                        <select name="payment_status" class="drop-down">
                           <option value="" selected disabled><?= htmlspecialchars($order['payment_status'] ?? 'pending'); ?></option>
                           <option value="pending">Pending</option>
                           <option value="completed">Completed</option>
                           <option value="cancelled">Cancelled</option>
                        </select>
                        <div class="flex-btn">
                           <button type="submit" name="update_payment" class="btn">
                              <i class="fas fa-sync"></i> Update Status
                           </button>
                           <a href="?delete=<?= htmlspecialchars($order['id']); ?>&view=<?= $view ?>" 
                              class="delete-btn" 
                              onclick="return confirm('Delete this order? This action cannot be undone.');">
                              <i class="fas fa-trash"></i> Delete Order
                           </a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
      <?php else: ?>
         <div class="order-card">
            <div class="no-orders">
               <i class="fas fa-clipboard-list"></i>
               <h3><?= $view == 'verification' ? 'No Orders Pending Verification' : 'No Orders Found' ?></h3>
               <p><?= $view == 'verification' ? 'All orders have been processed or there are no new orders requiring verification.' : 'No orders have been placed yet.' ?></p>
            </div>
         </div>
      <?php endif; ?>
   </section>

   <!-- Modal for image preview -->
   <div id="imageModal" class="modal">
      <div class="modal-content">
         <span class="close">&times;</span>
         <img id="modalImage" style="width: 100%; max-height: 80vh; object-fit: contain;">
      </div>
   </div>

   <script>
      // Modal functionality
      function openModal(imageSrc) {
         const modal = document.getElementById('imageModal');
         const modalImg = document.getElementById('modalImage');
         modal.style.display = 'block';
         modalImg.src = imageSrc;
      }

      // Close modal
      document.querySelector('.close').onclick = function() {
         document.getElementById('imageModal').style.display = 'none';
      }

      // Close modal when clicking outside
      window.onclick = function(event) {
         const modal = document.getElementById('imageModal');
         if (event.target == modal) {
            modal.style.display = 'none';
         }
      }

      // Confirmation for dangerous actions
      document.querySelectorAll('.delete-btn').forEach(button => {
         button.addEventListener('click', function(e) {
            if(this.tagName === 'A' || this.textContent.includes('Reject') || this.textContent.includes('Delete')) {
               if (!confirm('Are you sure? This action cannot be undone.')) {
                  e.preventDefault();
               }
            }
         });
      });

      // Auto-hide messages after 5 seconds
      setTimeout(function() {
         const messages = document.querySelectorAll('.message');
         messages.forEach(function(message) {
            message.style.transition = 'opacity 0.5s ease';
            message.style.opacity = '0';
            setTimeout(function() {
               message.remove();
            }, 500);
         });
      }, 5000);

      // Debug function to check image paths
      function debugImagePath(imgElement) {
         console.log('Image src:', imgElement.src);
         console.log('Image natural width:', imgElement.naturalWidth);
         console.log('Image natural height:', imgElement.naturalHeight);
      }
   </script>

   <?php 
   // Include admin script if it exists
   if(file_exists('../js/admin_script.js')) {
       echo '<script src="../js/admin_script.js"></script>';
   }
   ?>
</body>
</html>