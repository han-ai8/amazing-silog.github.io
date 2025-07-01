<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];

   // Example: Fetch user info from DB (adjust table/columns as needed)
   $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
   $stmt->execute([$user_id]);
   $fetch_user = $stmt->fetch(PDO::FETCH_ASSOC);

} else {
   header('location:login.php');
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Dashboard</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <style>
      body {
         margin: 0;
         font-family: Arial, sans-serif;
         background-color: #fffbea;
      }

      .header {
         background: #ffc107;
         padding: 15px 20px;
         display: flex;
         justify-content: space-between;
         align-items: center;
      }

      .header h1 {
         margin: 0;
         font-size: 22px;
         color: #000;
      }

      .dashboard-container {
         display: flex;
         flex-direction: column;
         align-items: center;
         padding: 40px 20px;
         gap: 30px;
      }

      .dashboard-image img {
         width: 100%;
         max-width: 300px;
         height: auto;
         border-radius: 10px;
         box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      }

      .dashboard-content {
         background: white;
         padding: 25px;
         border-radius: 10px;
         box-shadow: 0 4px 8px rgba(0,0,0,0.1);
         max-width: 400px;
         width: 100%;
         text-align: center;
      }

      .dashboard-content h2 {
         margin-bottom: 15px;
         color: #333;
      }

      .info-box {
         background-color: #eee;
         padding: 10px;
         margin: 8px 0;
         border-radius: 5px;
         text-align: left;
      }

      .btn {
         background-color: #b87333;
         color: white;
         padding: 10px 20px;
         text-decoration: none;
         display: inline-block;
         margin-top: 15px;
         border-radius: 5px;
         border: none;
         cursor: pointer;
      }

      @media (min-width: 768px) {
         .dashboard-container {
            flex-direction: row;
            justify-content: center;
         }

         .dashboard-image, .dashboard-content {
            flex: 1;
            max-width: 500px;
         }
      }
   </style>
</head>

<body>

   <div class="header">
      <h1>Amazing Silog Restobar</h1>
      <a href="logout.php" class="btn">Logout</a>
   </div>

   <div class="dashboard-container">
      <div class="dashboard-image">
         <img src="images/dashboard.png" alt="User Dashboard">
      </div>

      <div class="dashboard-content">
         <h2>Welcome!</h2>
         <div class="info-box"><strong>Full Name:</strong> <?= htmlspecialchars($fetch_user['name']) ?></div>
         <div class="info-box"><strong>Username:</strong> <?= htmlspecialchars($fetch_user['username']) ?></div>
         <div class="info-box"><strong>Email:</strong> <?= htmlspecialchars($fetch_user['email']) ?></div>
         <div class="info-box"><strong>Address:</strong> <?= htmlspecialchars($fetch_user['address']) ?></div>
         <div class="info-box"><strong>Loyalty Points:</strong> <?= htmlspecialchars($fetch_user['points']) ?> PTS</div>
         <a href="edit_profile.php" class="btn">Edit Profile</a>
      </div>
   </div>

</body>
</html>
