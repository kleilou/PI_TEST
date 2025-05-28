<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
     body {
            font-family: Arial, sans-serif;
            background-color:while;
            
            margin: 0;
        }

        

        /* Style général de la barre */
        .navbar {
            background-color:rgb(150, 221, 239);
            padding: 15px 30px;
            display: flex;
            /*align-items: center;*/
            justify-content: space-between;
            color: white;
            
        }

        .navbar h1 {
            margin: 0;
            font-size: 24px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
            margin: 0;
            padding: 0;
        }

        .nav-links li a:hover {
            text-decoration: underline;
        }

        
    .container {
            width: 500px;
            /*margin: 40px auto;*/
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px #ccc;
            border-radius: 8px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group label {
            width: 150px;
        }

        .form-group input {
            flex: 1;
            padding: 10px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        </style>
</head>
<body>

    <header class="main-header">
        <nav class="navbar">
            <h1><a href="#">Bienvenue</a></h1>
            <ul class="nav-links">
                <li><a href="Produits.php">Produits</a></li>
                <li><a href="Ajouter_un_produit.php">Ajouter un produit</a></li>
                <li><a href="#">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <br><br><br>


    <center>
    <div class="container">
        <h2>Ajouter un nouveau produit</h2>
        <form action=" Ajouter_un_produit.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="nom">Nom du produit</label>
                <input type="text" name="nom" id="nom" required>
            </div>

            <div class="form-group">
                <label for="prix">Prix</label>
                <input type="number" name="prix" id="prix" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" required>
            </div>

            

            <button type="submit" name="ajouter">Ajouter le produit</button>

        </form>
    </div>
    </center>
</body>
</html>




<?php  



$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "gestionstock";

// Connexion au serveur MySQL
$conn = new mysqli($serveur, $utilisateur, $mot_de_passe);
if ($conn->connect_error) {
    die("❌ Connexion au serveur échouée : " . $conn->connect_error);
}

// Créer la base de données si elle n'existe pas
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $base_de_donnees";
if ($conn->query($sql_create_db) === TRUE) {
    // Sélectionner la base
    $conn->select_db($base_de_donnees);
} else {
    die("❌ Erreur lors de la création de la base : " . $conn->error);
}

// Créer la table produit si elle n'existe pas
$sql_create_table = "CREATE TABLE IF NOT EXISTS produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL
)";
if (!$conn->query($sql_create_table)) {
    die("❌ Erreur lors de la création de la table : " . $conn->error);
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['nom'], $_POST['prix'], $_POST['stock'])) {
        $nom = trim($_POST['nom']);
        $prix = floatval($_POST['prix']);
        $stock = intval($_POST['stock']);

        $stmt = $conn->prepare("INSERT INTO produit (nom, prix, stock) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nom, $prix, $stock);

        if ($stmt->execute()) {
            echo "✅ Produit ajouté avec succès.";
        } else {
            echo "❌ Erreur lors de l'ajout : " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "❌ Tous les champs sont requis.";
    }
}

$conn->close();

?>




