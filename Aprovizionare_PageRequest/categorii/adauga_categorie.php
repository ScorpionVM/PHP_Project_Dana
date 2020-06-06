<?php
    session_start();

    include("../conectare.php");

    if(isset($_POST["actionare"]) && $_POST["actionare"] == "adauga"){
        $max = mysqli_fetch_array(mysqli_query($conectare, "SELECT MAX(codC) as maxCC FROM categorie"))["maxCC"] + 1;
        $den = $_POST["den"];
        $desc = $_POST["desc"];

        mysqli_query($conectare, "INSERT INTO categorie (codC, denumire, descriere) VALUES ($max, '$den', '$desc')");
        echo "<p>Categorie adaugata cu succes!</p>";
    }
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>