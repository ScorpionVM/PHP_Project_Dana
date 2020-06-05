<?php
    include("../conectare.php");

    if(isset($_GET["actionare"]) && $_GET["actionare"] == "sterge"){
        mysqli_query($conectare, "DELETE FROM furnizor WHERE CUI='".$_GET["furn_sel"]."'");
    }
?>
<body>
    <br>
    <a href="./index.php">Back</a>
</body>