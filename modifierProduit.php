<?php
// Connexion au serveur MySQL
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "gestionstock";
$conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);
if ($conn->connect_error) {
    die("❌ Connexion au serveur échouée : " . $conn->connect_error);
}

$ID = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$data = null;

// Récupération des données du produit
if ($ID > 0) {
    $up = mysqli_query($conn, "SELECT * FROM produit WHERE id=$ID");
    if ($up && mysqli_num_rows($up) > 0) {
        $data = mysqli_fetch_assoc($up);
    }
}

// Traitement de la mise à jour
if (isset($_POST["update"])) {
    $ID = intval($_POST["id"]);
    $nom = trim($_POST['nom']);
    $prix = floatval($_POST['prix']);
    $stock = intval($_POST['stock']);

    $sql_up = "UPDATE produit SET nom='$nom', prix='$prix', stock='$stock' WHERE id='$ID'";
    if (mysqli_query($conn, $sql_up)) {
        header("Location: Produits.php");
        exit();
    } else {
        echo "❌ Erreur lors de la mise à jour : " . mysqli_error($conn);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MODIFIER</title>
<style>
    body { font-family: Arial, sans-serif; margin: 0; background-color: white; }
    .navbar { background-color: rgb(150, 221, 239); padding: 15px 30px; display: flex; justify-content: space-between; color: white; }
    .navbar h1 { margin: 0; font-size: 24px; }
    .navbar a { color: white; text-decoration: none; margin-left: 20px; font-weight: bold; }
    .nav-links { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; }
    .nav-links li a:hover { text-decoration: underline; }
    .container { width: 500px; background: white; padding: 20px; box-shadow: 0px 0px 10px #ccc; border-radius: 8px; }
    .form-group { display: flex; align-items: center; margin-bottom: 15px; }
    .form-group label { width: 150px; }
    .form-group input { flex: 1; padding: 10px; }
    button { background-color: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; margin-top: 10px; }
    button:hover { background-color: #218838; }
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
    <h2>Mise à jour de produit</h2>
    <form action="modifierProduit.php?id=<?php echo $ID; ?>" method="POST">
        <div class="form-group">
            <label for="id">Id du produit</label>
            <input type="text" name="id" id="id" value='<?php echo isset($data["id"]) ? $data["id"] : ""; ?>' readonly>
        </div>
        <div class="form-group">
            <label for="nom">Nom du produit</label>
            <input type="text" name="nom" id="nom" value='<?php echo isset($data["nom"]) ? $data["nom"] : ""; ?>'>
        </div>
        <div class="form-group">
            <label for="prix">Prix</label>
            <input type="number" name="prix" id="prix" value='<?php echo isset($data["prix"]) ? $data["prix"] : ""; ?>' >
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" value='<?php echo isset($data["stock"]) ? $data["stock"] : ""; ?>'>
        </div>
       
        <button type="submit" name="update">Mise à jour du produit</button>
    </form>
</div>
</center>

</body>
</html>
