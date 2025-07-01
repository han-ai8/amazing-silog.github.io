<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   header('location:home.php');
   exit;
}

// Fetch user profile
$select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Profile</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
         transition: background 0.3s ease;
      }
      .logout-btn:hover {
         background-color: #864600;
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
      <p style="font-weight: bold; margin-bottom: 10px; font-size: 20px;">
         <?= htmlspecialchars($fetch_profile['name']); ?> <i class="fas fa-pen" title="Edit"></i>
      </p>

      <div class="info-group">
         <div class="info-label">USERNAME</div>
         <div class="info-value">
            <?= htmlspecialchars($fetch_profile['name']); ?>
            <i class="fas fa-pen"></i>
         </div>

         <div class="info-label">EMAIL</div>
         <div class="info-value">
            <?= htmlspecialchars($fetch_profile['email']); ?>
            <i class="fas fa-pen"></i>
         </div>

         <div class="info-label">ADDRESS</div>
         <div class="info-value">
            <?= htmlspecialchars($fetch_profile['address']); ?>
            <i class="fas fa-pen"></i>
         </div>

         <div class="info-label">LOYALTY POINTS</div>
         <div class="info-value">
            <?= htmlspecialchars($fetch_profile['loyalty_points'] ?? 0); ?> PTS.
         </div>
      </div>

      <form action="user_logout.php" method="post">
         <button type="submit" class="logout-btn">LOG OUT</button>
      </form>
   </div>
</div>

</body>
</html>
