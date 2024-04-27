<?php
// Initialisation des variables
$nom_complet = $email = $num_telephone = $objet = $message = '';
$nom_complet_err = $email_err = $num_telephone_err = $objet_err = $message_err = '';

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du champ Nom Complet
    if (empty($_POST["nom_complet"])) {
        $nom_complet_err = "Veuillez entrer votre nom complet.";
    } else {
        $nom_complet = trim($_POST["nom_complet"]);
        // Vérification du format du nom complet
        if (!preg_match("/^[a-zA-Z ]{3,}$/", $nom_complet)) {
            $nom_complet_err = "Le nom complet doit comporter au moins 3 lettres alphabétiques.";
        }
    }

    // Vérification du champ Email
    if (empty($_POST["email"])) {
        $email_err = "Veuillez entrer votre adresse email.";
    } else {
        $email = trim($_POST["email"]);
        // Vérification du format de l'adresse email
        /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Format d'email invalide.";
        }*/
    }

    // Vérification du champ Numéro de Téléphone (optionnel)
    if (!empty($_POST["num_telephone"])) {
        $num_telephone = trim($_POST["num_telephone"]);
        // Vérification du format du numéro de téléphone
       /* if (!preg_match("/^\d{10}$/", $num_telephone)) {
            $num_telephone_err = "Format de numéro de téléphone invalide.";
        }*/
    }

    // Vérification du champ Objet
    if (empty($_POST["objet"])) {
        $objet_err = "Veuillez entrer l'objet de votre message.";
    } else {
        $objet = trim($_POST["objet"]);
        // Vérification de la longueur de l'objet
        if (strlen($objet) < 3) {
            $objet_err = "L'objet doit comporter au moins 3 caractères.";
        }
    }

    // Vérification du champ Message
    if (empty($_POST["message"])) {
        $message_err = "Veuillez entrer votre message.";
    } else {
        $message = trim($_POST["message"]);
    }

    // Si aucune erreur de validation, insérer les données dans la base de données
    if (empty($nom_complet_err) && empty($email_err) && empty($num_telephone_err) && empty($objet_err) && empty($message_err)) {
        include("db.php");

        // Requête préparée pour insérer les données
        $requete = $bdd->prepare("INSERT INTO moncontacts (nomcomplet, Email, numtelephone, objet, message) VALUES (?, ?, ?, ?, ?)");

        // Liaison des paramètres
        $requete->bindParam(1, $nom_complet);
        $requete->bindParam(2, $email);
        $requete->bindParam(3, $num_telephone);
        $requete->bindParam(4, $objet);
        $requete->bindParam(5, $message);

        // Exécution de la requête
        if ($requete->execute()) {
            // Succès : rediriger vers une page de confirmation
            header("Location: confirmation.php");
            exit();
        } else {
            // Erreur lors de l'exécution de la requête
            echo "Erreur lors de l'enregistrement des données dans la base de données.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Formulaire de Contact</title>
</head>
<body>
    <div class="container">
        <h2>Formulaire de Contact</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="contact-form">
            <div class="form-group">
                <label for="nom_complet">Nom Complet:</label><br>
                <input type="text" id="nom_complet" name="nom_complet" class="input-field" value="<?php echo htmlspecialchars($nom_complet); ?>" required>
                <span class="error"><?php echo $nom_complet_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" class="input-field" value="<?php echo htmlspecialchars($email); ?>" required>
                <span class="error"><?php echo $email_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="num_telephone">Numéro de Téléphone:</label><br>
                <input type="text" id="num_telephone" name="num_telephone" class="input-field" value="<?php echo htmlspecialchars($num_telephone); ?>">
                <span class="error"><?php echo $num_telephone_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="objet">Objet:</label><br>
                <input type="text" id="objet" name="objet" class="input-field" value="<?php echo htmlspecialchars($objet); ?>" required>
                <span class="error"><?php echo $objet_err; ?></span><br>
            </div>

            <div class="form-group">
                <label for="message">Message:</label><br>
                <textarea id="message" name="message" rows="4" class="input-field" required><?php echo htmlspecialchars($message); ?></textarea>
                <span class="error"><?php echo $message_err; ?></span><br>
            </div>

            <input type="submit" value="Envoyer" class="submit-btn">
        </form>
    </div>
</body>
</html>
