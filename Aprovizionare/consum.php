<?php
    session_start();

    include_once("conectare.php");
    if(!isset($_SESSION["selected_cat_mod"])) {
        $_SESSION["selected_cat_mod"] = "";
    }
       
    if(isset($_POST["back"]) && ($_POST["back"] == "back")){
        header("Location: index.php");
    }
    
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
        } else {
            echo "Error: Nu poate fi consumat in minus!\nCantitatea la moment $stoc Kg.\n Cantitatea pentru consum $cantCons Kg!";
        }
        
    } else if(isset($_GET["actionare"]) && $_GET["actionare"] == "select"){

        if(isset($_SESSION["selected_cat_mod"])){
            $_SESSION["selected_cat_mod"] = $_GET["cat_sel"];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consum</title>
</head>
<body>
    <h1>Consum</h1>

    <div>
        <form action="consum.php" method="GET">
            <label>Categoria : </label>
            <select name="cat_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                    while($row=mysqli_fetch_array($fill)) {      
                        if($_SESSION["selected_cat_mod"] == $row["codC"]) {
                            $stat = "selected";
                        } else { $stat = ""; }
                        echo "<option value='".$row["codC"]."' $stat>".$row["denumire"]."</option>";
                    }
                ?>
            </select>
            <button type="submit" name="actionare" value="select">Select</button>
        </form>
        <form action="consum.php" method="POST">
            <label>Produsul : </label>
            <select name="prd_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs WHERE codC='".$_SESSION["selected_cat_mod"]."'");
                    while($row=mysqli_fetch_array($fill)) {
	                    echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
                    }
                ?>
            </select><br>
            <label>Cantitate Consumata : </label><input type="text" name="cant" required/><label> Kg</label><br><br>
            <button type="submit" name="actionare" value="cons">Consuma</button>
        </form>
    </div><br>

    <div>
        <table border>
            <tr>
                <th colspan="2">Top 10 consumari in ultimile 30 zile</th>
            </tr>
            <?php
                $data_start = date('Y-m-d', strtotime("-30 days"));
                $data_end = date('Y-m-d');

                $select = mysqli_query($conectare, "SELECT codProdus, SUM(cantitate) as maxcons FROM consumare WHERE '$data_start' < dataCons AND dataCons < '$data_end' GROUP BY codProdus ASC LIMIT 10");
                //echo " $data_start : $data_end";

                while($row=mysqli_fetch_array($select)) {
                    $prd = mysqli_fetch_array(mysqli_query($conectare, "SELECT denumireProdus FROM produs WHERE codProdus=".$row["codProdus"]));
                    echo "<tr>
                        <td>".$prd["denumireProdus"]."</td>
                        <td>".$row["maxcons"]."</td>
                    </tr>";
                }
            ?>
        </table>
    </div><br>
    

    <form action="consum.php" method="POST">
        <button type="submit" name="back" value="back">back</button>
    </form>
</body>
</html>