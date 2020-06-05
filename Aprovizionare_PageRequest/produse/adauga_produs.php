<?php
    include("../conectare.php");
    
    if(isset($_POST["actionare"]) && ($_POST["actionare"] == "adauga")){
        $max = mysqli_fetch_array(mysqli_query($conectare, "SELECT MAX(codProdus) as maxCP FROM produs"))["maxCP"] + 1;
        $denP = $_POST["den"];
        $desc = $_POST["desc"];
        $codC = $_POST["cat_sel"];
        mysqli_query($conectare, "INSERT INTO produs (codProdus, denumireProdus, UM, descriere, codC, stoc) VALUES ($max, '$denP', 'kg', '$desc', $codC, 0.0)");
        
        echo "<p>Produsul nou a fost adaugat cu succes!</p>";
    }
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>