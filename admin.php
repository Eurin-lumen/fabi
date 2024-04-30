<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau d'administration</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php
    include 'db.php';  // Inclut le fichier de connexion à la base de données

    $sql = "SELECT * FROM moncontacts";
    $stmt = $bdd->prepare($sql);

    try {
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($results) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Nom Complet</th>
                        <th>Email</th>
                        <th>Numéro de Téléphone</th>
                        <th>Objet</th>
                        <th>Message</th>
                        <th>Date de Création</th>
                        <th>Actions</th>
                    </tr>";
            foreach ($results as $row) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["nomcomplet"]."</td>
                        <td>".$row["Email"]."</td>
                        <td>".$row["numtelephone"]."</td>
                        <td>".$row["objet"]."</td>
                        <td>".htmlspecialchars($row["message"])."</td>
                        <td>".$row["created_at"]."</td>
                        <td>
                            <a href='edit.php?id=".$row["id"]."'>Modifier</a>
                            <a href='delete.php?id=".$row["id"]."' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?');\">Supprimer</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<div class='message error'>Aucun résultat trouvé.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='message error'>Erreur lors de la requête SQL : " . $e->getMessage() . "</div>";
    }
    ?>
</body>
</html>
