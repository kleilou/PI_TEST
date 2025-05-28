<?php 
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "gestionstock";

$conn = new mysqli($serveur, $utilisateur, $mot_de_passe ,$base_de_donnees); 

$ID = $_GET["id"];
$sql_delete = "DELETE FROM produit WHERE id = $ID";

if ($conn->query($sql_delete) === TRUE) {
    echo "✅ Produit supprimé avec succès.";
} else {
    echo "❌ Erreur lors de la suppression : " . $conn->error;
}

header("Location: Produits.php");
exit();

$conn->close();

?>





