<?php
    include("../conectare.php");
    
    if(isset($_GET["actionare"]) && $_GET["actionare"] == "sterge") {
        mysqli_query($conectare, "DELETE FROM produs WHERE codProdus=".$_GET["prd_sel"]);
        echo "<p>Produsul a fost sters cu success!</p>";
    }
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>