<?php
include 'db.php';  // Inclut le fichier de connexion à la base de données

// Préparation de la requête SQL
$sql = "SELECT * FROM moncontacts";
$stmt = $bdd->prepare($sql);

try {
    // Exécution de la requête
    $stmt->execute();

    // Vérification si la requête a retourné des résultats
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Numéro de Téléphone</th>
                    <th>Objet</th>
                    <th>Message</th>
                    <th>Date de Création</th>
                </tr>";
        // Affichage de chaque ligne de résultat
        foreach ($results as $row) {
            echo "<tr>
                    <td>".$row["id"]."</td>
                    <td>".$row["nomcomplet"]."</td>
                    <td>".$row["Email"]."</td>
                    <td>".$row["numtelephone"]."</td>
                    <td>".$row["objet"]."</td>
                    <td>".htmlspecialchars($row["message"])."</td>
                    <td>".$row["created_at"]."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
} catch (PDOException $e) {
    // En cas d'erreur lors de l'exécution de la requête
    die("Erreur lors de la requête SQL : " . $e->getMessage());
}

// Pas besoin de fermer la connexion PDO explicitement
?>
