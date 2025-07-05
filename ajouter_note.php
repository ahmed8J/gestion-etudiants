<?php
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}
require_once 'config.php';

$message = '';
$etudiant = null;

// Étape 1 : Rechercher un étudiant
if (isset($_GET['nom']) && !empty($_GET['nom'])) {
    $nom = $_GET['nom'];
    $like = "%$nom%";
    $stmt = $conn->prepare("SELECT * FROM etudiants WHERE nom LIKE ?");
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $etudiants = $result->fetch_all(MYSQLI_ASSOC);
}

// Étape 2 : Enregistrer une note
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['note'])) {
    $id = intval($_POST['id']);
    $note = floatval($_POST['note']);

    $stmt = $conn->prepare("UPDATE etudiants SET note = ? WHERE id = ?");
    $stmt->bind_param("di", $note, $id);
    $stmt->execute();

    $message = "✅ Note mise à jour avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter ou Modifier une Note</title>
  <link rel="stylesheet" href="css/dashboard.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f6f9;
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: #1a237e;
    }

    .message {
      color: green;
      text-align: center;
      font-weight: bold;
      margin-bottom: 15px;
    }

    form {
      text-align: center;
      margin-bottom: 30px;
    }

    input[type="text"], input[type="number"] {
      padding: 10px;
      width: 250px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin: 5px;
    }

    button {
      background-color: #1a73e8;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    table {
      margin: 0 auto;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 80%;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #e0e0e0;
    }

    th {
      background-color: #1a73e8;
      color: white;
    }

    tr:hover {
      background-color: #f5f5f5;
    }
  </style>
</head>
<body>

<h1>Ajouter / Modifier la note d'un étudiant</h1>

<?php if ($message): ?>
  <div class="message"><?= $message ?></div>
<?php endif; ?>

<form method="get">
  <input type="text" name="nom" placeholder="Entrer le nom de l'étudiant">
  <button type="submit">Rechercher</button>
</form>

<?php if (!empty($etudiants)): ?>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Email</th>
        <th>Note actuelle</th>
        <th>Modifier la note</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($etudiants as $et): ?>
        <tr>
          <td><?= htmlspecialchars($et['nom']) ?></td>
          <td><?= htmlspecialchars($et['prenom']) ?></td>
          <td><?= htmlspecialchars($et['email']) ?></td>
          <td><?= htmlspecialchars($et['note']) ?></td>
          <td>
            <form method="post" style="display:flex; justify-content:center;">
              <input type="hidden" name="id" value="<?= $et['id'] ?>">
              <input type="number" step="0.01" name="note" value="<?= $et['note'] ?>" required>
              <button type="submit">Enregistrer</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php elseif (isset($_GET['nom'])): ?>
  <p style="text-align:center;">Aucun étudiant trouvé avec ce nom.</p>
<?php endif; ?>

</body>
</html>
