<?php
include 'db.php'; // Assurez-vous d'inclure votre connexion à la base de données

// Vérification de l'ID passé via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Préparation de la requête de suppression
    $stmt = $bdd->prepare("DELETE FROM moncontacts WHERE id = ?");
    $result = $stmt->execute([$id]);

    if ($result) {
        $message = "Contact supprimé avec succès.";
    } else {
        $message = "Erreur lors de la suppression du contact.";
    }
} else {
    $message = "ID invalide.";
}

// Redirection vers la page d'administration avec un message
header("Location: admin.php?message=" . urlencode($message));
exit;
