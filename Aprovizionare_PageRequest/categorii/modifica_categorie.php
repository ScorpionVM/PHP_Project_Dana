<?php
    include("../conectare.php");
    include("../global_func.php");
    
    if(isset($_POST["actionare"]) && $_POST["actionare"] == "modifica"){            
        $row = mysqli_fetch_array(mysqli_query($conectare, "SELECT denumire, descriere FROM categorie WHERE codC=".$_POST["cat_sel"]));
        $old_name = $row["denumire"];
        $old_desc = $row["descriere"];

        $new_name = ifnull($_POST["denN"], $old_name);
        $new_desc = ifnull($_POST["desc"], $old_desc);
        
        mysqli_query($conectare, "UPDATE categorie SET denumire='$new_name', descriere='$new_desc' WHERE codC='".$_POST["cat_sel"]."'")or die("Error: Categorie");            
        echo "<p>Date modificate cu succes!</p>";
    }

?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>