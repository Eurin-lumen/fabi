<?php
include 'db.php'; // Assurez-vous d'inclure votre connexion à la base de données

// Vérification de l'ID passé via GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Préparation de la requête pour obtenir les détails de l'entrée
    $stmt = $bdd->prepare("SELECT * FROM moncontacts WHERE id = ?");
    $stmt->execute([$id]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si l'entrée existe
    if (!$contact) {
        echo "<p class='message error'>Contact non trouvé.</p>";
        exit;
    }
} else {
    echo "<p class='message error'>ID invalide.</p>";
    exit;
}

// Traitement de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collecte des nouvelles valeurs
    $nomcomplet = htmlspecialchars($_POST['nomcomplet']);
    $email = htmlspecialchars($_POST['email']);
    $numtelephone = htmlspecialchars($_POST['numtelephone']);
    $objet = htmlspecialchars($_POST['objet']);
    $message = htmlspecialchars($_POST['message']);

    // Mise à jour de la base de données
    $updateStmt = $bdd->prepare("UPDATE moncontacts SET nomcomplet = ?, email = ?, numtelephone = ?, objet = ?, message = ? WHERE id = ?");
    $updateStmt->execute([$nomcomplet, $email, $numtelephone, $objet, $message, $id]);

    echo "<p class='message success'>Contact mis à jour avec succès.</p>";
    // Redirection ou autre logique de post-traitement peut être ajoutée ici
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Contact</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="edit.css">
  

</head>
<body>
    <h2>Modifier Contact</h2>
    <form method="post">
        <div>
            <label>Nom Complet:</label>
            <input type="text" name="nomcomplet" value="<?php echo $contact['nomcomplet']; ?>" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo $contact['Email']; ?>" required>
        </div>
        <div>
            <label>Numéro de Téléphone:</label>
            <input type="text" name="numtelephone" value="<?php echo $contact['numtelephone']; ?>">
        </div>
        <div>
            <label>Objet:</label>
            <input type="text" name="objet" value="<?php echo $contact['objet']; ?>" required>
        </div>
        <div>
            <label>Message:</label>
            <textarea name="message" required><?php echo $contact['message']; ?></textarea>
        </div>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
