<?php
    include("../conectare.php");
    include("../global_func.php");
    
    if(isset($_GET["actionare"]) && ($_GET["actionare"] == "modifica")){
        $select = mysqli_query($conectare, "SELECT denumireProdus, descriere FROM produs WHERE codProdus=".$_GET["prd_sel"]);

        while($row=mysqli_fetch_array($select)){
            $old_den = $row["denumireProdus"];
            $old_desc = $row["descriere"];
        }

        $new_den = ifnull($_GET["denN"], $old_den);
        $new_desc = ifnull($_GET["desc"], $old_desc);

        mysqli_query($conectare, "UPDATE produs SET denumireProdus='$new_den', descriere='$new_desc' WHERE codProdus=".$_GET["prd_sel"]);
        echo "<p>Valorile noi pentru produsul '$old_den' sunt:<br>Denumire: '$old_den' -> '$new_den'<br>Descriere: '$old_desc' -> '$new_desc'</p>";
    }
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>