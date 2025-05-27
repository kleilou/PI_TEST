
<?php
// Connexion à la base de données
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "gestionstock";

$conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);
if ($conn->connect_error) {
    die("❌ Connexion échouée : " . $conn->connect_error);
}

// Récupérer les produits
$result = $conn->query("SELECT * FROM produit");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Liste des produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #96ddef;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            color: white;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 20px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 40px;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px #ccc;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #e2f5fc;
        }

        img {
            max-width: 80px;
            height: auto;
        }
    </style>
</head>
<body>

<header class="navbar">
    <h1><a href="#">Bienvenue</a></h1>
    <ul class="nav-links">
        <li><a href="acceuil.php">Accueil</a></li>
        <li><a href="Ajouter_un_produit.php">Ajouter un produit</a></li>
        <li><a href="#">Déconnexion</a></li>
    </ul>
</header>

<div class="container">
    <h2>Liste des produits</h2>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prix (€)</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= number_format($row['prix'], 2, ',', ' ') ?> €</td>
                    <td><?= (int)$row['stock'] ?></td>
                    
                    <td>
                        <?php if (!empty($row['image'])): ?>
                            <img src="<?= htmlspecialchars($row['image']) ?>" alt="Image produit">
                        <?php else: ?>
                            Pas d'image
                        <?php endif; ?>

                    </td>
                    <td>
                    <a href="modifier_produit.php?id=<?= $row['id'] ?>">✏️ Modifier</a> |
                    <a href="supprimer_produit.php?id=<?= $row['id'] ?>" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?')">🗑️ Supprimer</a>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();


?>