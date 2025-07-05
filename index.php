<?php
session_start();
if (isset($_POST['username'], $_POST['password'])) {
    if ($_POST['username']==='admin' && $_POST['password']==='admin') {
        $_SESSION['admin']=true;
        header("Location: dashboard.php"); exit;
    } else {
        $error="Identifiants incorrects";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Connexion Admin</title>
  <link rel="stylesheet" href="templates/glass-login/style.css">
  <script src="templates/glass-login/main.js" defer></script>
</head>
<body>
  <?php include 'templates/glass-login/tamplate.html'; ?>

  <?php if (!empty($error)): ?>
    <p class="error-message"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
<canvas id="canvas"></canvas>
<script src="cursor-trail.js"></script>
</body>
</html>

