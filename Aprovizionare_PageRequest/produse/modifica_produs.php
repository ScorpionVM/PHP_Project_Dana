<?php
    include("../conectare.php");
    include("../global_func.php");
    
    if(isset($_GET["actionare"]) && ($_GET["actionare"] == "modifica")){
        $row = mysqli_fetch_array(mysqli_query($conectare, "SELECT denumireProdus, descriere FROM produs WHERE codProdus=".$_GET["prd_sel"]));
        $old_den = $row["denumireProdus"];
        $old_desc = $row["descriere"];

        $new_den = ifnull($_GET["denN"], $old_den);
        $new_desc = ifnull($_GET["desc"], $old_desc);

        mysqli_query($conectare, "UPDATE produs SET denumireProdus='$new_den', descriere='$new_desc' WHERE codProdus=".$_GET["prd_sel"]) or die("Error: Produs");
        echo "<p>Date modificate cu succes!</p>";
    }
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>