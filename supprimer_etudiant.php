<?php
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
require_once 'config.php';

$etudiants = [];
if (isset($_GET['recherche']) && !empty($_GET['recherche'])) {
    $nom = $_GET['recherche'];
    $stmt = $conn->prepare("SELECT * FROM etudiants WHERE nom LIKE ?");
    $like = "%$nom%";
    $stmt->bind_param("s", $like);
} else {
    $stmt = $conn->prepare("SELECT * FROM etudiants");
}

$stmt->execute();
$result = $stmt->get_result();
$etudiants = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Supprimer Étudiant</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f7fa;
      margin: 0;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #1a237e;
    }

    form {
      text-align: center;
      margin-bottom: 30px;
    }

    input[type="text"] {
      padding: 10px;
      width: 250px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button[type="submit"] {
      background-color: #1a73e8;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-left: 10px;
    }

    table {
      width: 90%;
      margin: 0 auto;
      border-collapse: collapse;
      background-color: #fff;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    table thead {
      background-color: #1a73e8;
      color: white;
    }

    table th, table td {
      padding: 14px 12px;
      text-align: center;
      font-size: 15px;
      border-bottom: 1px solid #e0e0e0;
    }

    table tr:hover {
      background-color: #f5f5f5;
    }

    .delete-button {
      background-color: #e53935;
      color: white;
      padding: 6px 12px;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .delete-button:hover {
      background-color: #c62828;
    }
  </style>
</head>
<body>

  <h1>Supprimer un étudiant</h1>

  <form method="get">
    <input type="text" name="recherche" placeholder="Rechercher par nom...">
    <button type="submit">Rechercher</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Date naissance</th>
        <th>Note</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
  <?php foreach ($etudiants as $etudiant): ?>
    <tr>
      <td><?= htmlspecialchars($etudiant['nom']) ?></td>
      <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
      <td><?= htmlspecialchars($etudiant['email']) ?></td>
      <td><?= htmlspecialchars($etudiant['naissance']) ?></td>
      <td><?= htmlspecialchars($etudiant['note']) ?></td>
      <td>
        <form method="post" action="supprimer_action.php" onsubmit="return confirm('Supprimer cet étudiant ?');">
          <input type="hidden" name="id" value="<?= $etudiant['id'] ?>">
          <button type="submit" class="delete-button">Supprimer</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>
