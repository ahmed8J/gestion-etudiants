<?php
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<style>
    body, html {
        margin: 0;
        padding: 0;
        overflow: hidden;
        height: 100%;
        background: #151f28;
    }

    canvas {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        z-index: -1; /* important pour ne pas bloquer le contenu */
    }
</style>

  <meta charset="UTF-8">
  <title>ESIAI - Admin</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
<div class="topbar-contact">
  <span>📞 +212-536542585 / +212-680797959</span>
  <span>📧 esiai.oujda@gmail.com</span>
</div>


<header class="navbar">
  <div class="logo-container">
    <img src="asset/img/logo.png" alt="ESIAI Logo">
  </div>
  <nav class="nav-links">
    <a href="dashboard.php" class="active">Accueil</a>
    <a href="ajouter_etudiant.php">Ajouter étudiant</a>
    <a href="supprimer_etudiant.php">Supprimer étudiant</a>
    <a href="ajouter_note.php">Les notes</a>
    <a href="logout.php">Déconnexion</a>
  </nav>
</header>



</body>
</html>
