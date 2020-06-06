<?php
    include("../conectare.php");
    
    if(isset($_POST["actionare"]) && ($_POST["actionare"] == "adauga")){
        $max = mysqli_fetch_array(mysqli_query($conectare, "SELECT MAX(codProdus) as maxCP FROM produs"))["maxCP"] + 1;
        $denP = $_POST["den"];
        $desc = $_POST["desc"];
        $codC = $_POST["cat_sel"];
        $zile = $_POST["term"];
        
        $dataFabr = date("Y-m-d");
        $dataExp = date("Y-m-d", strtotime("+$zile days"));

        mysqli_query($conectare, "INSERT INTO produs (codProdus, denumireProdus, UM, dataFabr, dataExp,  descriere, codC, stoc) VALUES ($max, '$denP', 'kg', '$dataFabr', '$dataExp',  '$desc', $codC, 0.0)") or die("Error can't insert");
        
        echo "<p>Produsul nou a fost adaugat cu succes!</p>";
    }
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>