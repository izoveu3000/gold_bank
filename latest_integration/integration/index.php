<?php
$hour = date("H");
if ($hour < 12) {
    $greeting = "Good Morning, User";
} elseif ($hour < 17) {
    $greeting = "Good Afternoon, User";
} else {
    $greeting = "Good Evening, User";
}
$quote = "Welcome to Examly – Your Future Starts Here";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      font-family: 'Inter', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      overflow: hidden;
      background: linear-gradient(-45deg, #0f172a, #1e3a8a, #2563eb, #9333ea);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
    }

    .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.6;
      animation: float 20s ease-in-out infinite;
      z-index: 0;
    }
    .orb1 { width: 400px; height: 400px; background: #3b82f6; top: 10%; left: 15%; }
    .orb2 { width: 500px; height: 500px; background: #9333ea; bottom: 10%; right: 15%; animation-delay: 5s; }
    .orb3 { width: 300px; height: 300px; background: #ec4899; top: 60%; left: 30%; animation-delay: 10s; }

    .intro-container {
      text-align: center;
      z-index: 1;
    }

    h1, h2 {
      margin: 0;
      font-weight: bold;
      opacity: 0;
    }

    h1 {
      font-size: 3rem;
      animation: slideUp 2s ease forwards;
      animation-delay: 0.5s;
    }

    h2 {
      font-size: 2rem;
      margin-top: 20px;
      font-weight: 400;
      animation: fadeIn 2s ease forwards;
      animation-delay: 2s;
    }

    .btn {
      display: inline-block;
      padding: 12px 24px;
      font-size: 1.2rem;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 12px;
      color: white;
      text-decoration: none;
      transition: all 0.3s ease;
      opacity: 0;
      animation: fadeIn 2s ease forwards;
      animation-delay: 4s;
    }

    .btn:hover {
      background: rgba(255, 255, 255, 0.4);
      transform: translateY(-3px);
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes slideUp {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    @keyframes float {
      0%, 100% { transform: translateY(0) translateX(0); }
      50% { transform: translateY(-50px) translateX(30px); }
    }
  </style>
</head>
<body>
  <!-- background orbs -->
  <div class="orb orb1"></div>
  <div class="orb orb2"></div>
  <div class="orb orb3"></div>

  <div class="intro-container">
    <h1><?= $greeting ?></h1>
    <h2><?= $quote ?></h2>
    <br><br>
    <a href="admin/login.php" class="btn">→ Continue</a>
  </div>
</body>
</html>