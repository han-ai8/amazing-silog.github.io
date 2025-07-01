<?php
include 'components/connect.php';
session_start();

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
   echo '
   <!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Login Required</title>
      <style>
         body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: rgba(0,0,0,0.6);
         }
         .popup-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
         }
         .popup-box {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
         }
         .popup-box h2 {
            margin-bottom: 20px;
            font-size: 22px;
            color: #333;
         }
         .popup-box a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background: #a65500;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
         }
         .popup-box a:hover {
            background: #864600;
         }
      </style>
   </head>
   <body>
      <div class="popup-overlay">
         <div class="popup-box">
            <h2>You must log in to access this page.</h2>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            <a href="home.php">Cancel</a>
         </div>
      </div>
   </body>
   </html>';
   exit;
}
$user_id = $_SESSION['user_id'];
?>

<?php

include 'components/connect.php';


if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
   exit;
}

$fetch_profile = [];
$get_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
$get_profile->execute([$user_id]);

if ($get_profile->rowCount() > 0) {
   $fetch_profile = $get_profile->fetch(PDO::FETCH_ASSOC);
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
   $new_name = htmlspecialchars(trim($_POST['name']));
   $new_email = htmlspecialchars(trim($_POST['email']));
   $new_address = htmlspecialchars(trim($_POST['address']));

   $update = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ? WHERE id = ?");
   $update->execute([$new_name, $new_email, $new_address, $user_id]);

   // Refresh profile data
   $get_profile->execute([$user_id]);
   $fetch_profile = $get_profile->fetch(PDO::FETCH_ASSOC);

   echo "<script>alert('Profile updated successfully!');</script>";
}
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
   <title>My Profile</title>

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- Custom CSS -->
   <style>
      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
         background-color: #fff9e6;
      }

      .container {
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
      }

      .profile-card {
         background: white;
         border-radius: 10px;
         box-shadow: 0 0 15px rgba(0,0,0,0.1);
         padding: 30px;
         max-width: 400px;
         width: 90%;
         text-align: center;
      }

      .profile-card h2 {
         margin-bottom: 10px;
         color: #333;
         font-size: 30px;
      }
      .profile-card h2 p{
         margin-bottom: 10px;
         color: #333;
         font-size: 20px;
      }

      .info-group {
         margin: 20px 0;
         text-align: left;
      }

      .info-label {
         display: inline-block;
         background: #e0e0e0;
         padding: 5px 15px;
         border-radius: 20px;
         font-size: 12px;
         margin-bottom: 5px;
      }

      .info-value {
         font-size: 16px;
         color: #444;
         display: flex;
         align-items: center;
         justify-content: space-between;
         border-bottom: 1px solid #ddd;
         padding: 8px 0;
      }

      .info-value i {
         color: #007bff;
         cursor: pointer;
      }

      .logout-btn {
         background-color: #a65500;
         color: white;
         border: none;
         padding: 10px 20px;
         font-size: 14px;
         border-radius: 5px;
         cursor: pointer;
         margin-top: 20px;
         transition: .2s linear;
      }

      .logout-btn:hover {
         background-color:#fed330;
         letter-spacing:.1rem;
      }
      .changes-btn{
         background-color:#e74c3c;
         color: white;
         border: none;
         padding: 10px 20px;
         font-size: 14px;
         border-radius: 5px;
         cursor: pointer;
         margin-top: 20px;
         transition: .2s linear;
      }
      .changes-btn:hover {
         letter-spacing:.1rem;
      }

      @media (max-width: 480px) {
         .profile-card {
            padding: 20px;
         }
         .info-value {
            font-size: 14px;
         }
      }
   </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="container">
<div class="profile-card">
   <h2>Welcome!</h2>

<form id="profileForm" action="" method="post" class="info-group">
   <!-- USERNAME -->
   <div class="info-label">USERNAME</div>
   <div class="info-value">
      <input type="text" name="name" id="name" value="<?= htmlspecialchars($fetch_profile['name']); ?>" data-original="<?= htmlspecialchars($fetch_profile['name']); ?>" readonly style="border:none; background:transparent; width:100%; color:#444;">
      <i class="fas fa-pen" onclick="enableEdit('name')"></i>
   </div>

   <!-- EMAIL -->
   <div class="info-label">EMAIL</div>
   <div class="info-value">
      <input type="email" name="email" id="email" value="<?= htmlspecialchars($fetch_profile['email']); ?>" data-original="<?= htmlspecialchars($fetch_profile['email']); ?>" readonly style="border:none; background:transparent; width:100%; color:#444;">
      <i class="fas fa-pen" onclick="enableEdit('email')"></i>
   </div>

   <!-- ADDRESS -->
   <div class="info-label">ADDRESS</div>
   <div class="info-value">
      <textarea name="address" id="address" rows="2" data-original="<?= htmlspecialchars($fetch_profile['address']); ?>" readonly style="border:none; background:transparent; width:100%; resize:none; color:#444;"><?= htmlspecialchars($fetch_profile['address']); ?></textarea>
      <i class="fas fa-pen" onclick="enableEdit('address')"></i>
   </div>

   <!-- LOYALTY POINTS -->
   <div class="info-label">LOYALTY POINTS</div>
   <div class="info-value">
      <?= htmlspecialchars($fetch_profile['loyalty_points'] ?? 0); ?> PTS.
   </div>

   <!-- Buttons -->
   <div style="display: flex; gap: 50px; margin-top: 10px;">
      <button type="submit" name="update_profile" class="changes-btn">SAVE CHANGES</button>
      <button type="button" class="logout-btn" style="background: #ccc; color: #333;" onclick="cancelEdits()">CANCEL</button>
   </div>
</form>

   <form action="components/user_logout.php" method="post">
      <button type="submit" class="logout-btn">LOG OUT</button>
   </form>
</div>

</div>
<script>
function enableEdit(fieldId) {
   const field = document.getElementById(fieldId);
   field.removeAttribute('readonly');
   field.style.background = '#fff';
   field.focus();
}

function cancelEdits() {
   const form = document.getElementById('profileForm');
   const elements = form.querySelectorAll('input, textarea');

   elements.forEach(el => {
      if (el.hasAttribute('data-original')) {
         el.value = el.getAttribute('data-original');
         el.setAttribute('readonly', true);
         el.style.background = 'transparent';
      }
   });
}
</script>
</body>
</html>
