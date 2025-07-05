<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $stmt = $conn->prepare("DELETE FROM etudiants WHERE id = ?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
}

header("Location: supprimer_etudiant.php");
exit;
