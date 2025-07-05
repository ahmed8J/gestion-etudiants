<?php
session_start();
if (empty($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// Connexion à la base
$conn = new mysqli("localhost", "root", "", "gestion_etudiants");
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$etudiant = null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $naissance = $_POST["naissance"];
    $note = $_POST["note"];

    $stmt = $conn->prepare("INSERT INTO etudiants (nom, prenom, email, naissance, note) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $nom, $prenom, $email, $naissance, $note);
    $stmt->execute();

    $etudiant = [
        "nom" => $nom,
        "prenom" => $prenom,
        "email" => $email,
        "naissance" => $naissance,
        "note" => $note
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter Étudiant</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f2f5;
      padding: 40px;
    }

    h2 {
      text-align: center;
      color: #1a237e;
    }

    form {
      background-color: #fff;
      padding: 25px;
      width: 400px;
      margin: 0 auto;
      border-radius: 10px;
      box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
    }

    input, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    button {
      background-color: #1a73e8;
      color: white;
      font-weight: bold;
      cursor: pointer;
      border: none;
    }

    table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px;
      border: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #1a73e8;
      color: white;
    }

    .back {
      text-align: center;
      margin-top: 20px;
    }

    .back a {
      text-decoration: none;
      color: #1a73e8;
    }
  </style>
</head>
<body>

<h2>Ajouter un étudiant</h2>

<form method="POST">
  <input type="text" name="nom" placeholder="Nom" required>
  <input type="text" name="prenom" placeholder="Prénom" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="date" name="naissance" required>
  <input type="number" step="0.01" name="note" placeholder="Note" required>
  <button type="submit">Ajouter</button>
</form>

<?php if ($etudiant): ?>
  <h2>Étudiant ajouté</h2>
  <table>
    <tr>
      <th>Nom</th>
      <th>Prénom</th>
      <th>Email</th>
      <th>Date de naissance</th>
      <th>Note</th>
    </tr>
    <tr>
      <td><?= htmlspecialchars($etudiant["nom"]) ?></td>
      <td><?= htmlspecialchars($etudiant["prenom"]) ?></td>
      <td><?= htmlspecialchars($etudiant["email"]) ?></td>
      <td><?= htmlspecialchars($etudiant["naissance"]) ?></td>
      <td><?= htmlspecialchars($etudiant["note"]) ?></td>
    </tr>
  </table>
<?php endif; ?>

<div class="back">
  <a href="dashboard.php">← Retour au Dashboard</a>
</div>

</body>
</html>
