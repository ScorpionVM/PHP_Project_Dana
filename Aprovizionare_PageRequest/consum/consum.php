<?php
    include_once("../conectare.php");
    
    if(isset($_POST["actionare"]) && $_POST["actionare"] == "cons"){
        $dataCons = date("Y-m-d");
        $codProd = $_POST["prd_sel"];
        $cantCons = floatval($_POST["cant"]);

        $select = mysqli_query($conectare, "SELECT stoc FROM produs WHERE codProdus=$codProd");
        $row = mysqli_fetch_array($select);
        $stoc = floatval($row["stoc"]); 

        if($stoc - $cantCons > 0){
            mysqli_query($conectare, "INSERT INTO consumare (codProdus, dataCons, cantitate) VALUES ($codProd, '$dataCons', $cantCons)");
            mysqli_query($conectare, "UPDATE produs SET stoc=stoc-$cantCons WHERE codProdus=$codProd");    

            echo "Din stocul produsului sa consumat -$cantCons KG";
        } else {
            echo "Error: Nu poate fi consumat in minus!\nCantitatea la moment $stoc Kg.\n Cantitatea pentru consum $cantCons Kg!";
        }
        
    } 
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>