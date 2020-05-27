<?php
    session_start();

    include_once("conectare.php");

    if(isset($_POST["back"]) && ($_POST["back"] == "back")){
        header("Location: index.php");
    }
    
    if(isset($_POST["actionare"]) && $_POST["actionare"] == "aprov"){
        $select = mysqli_query($conectare, "SELECT nrFact FROM factura");
        $maxNrFact = 0;
        while($row=mysqli_fetch_array($select)){
            if ($maxNrFact < $row["nrFact"]){
                $maxNrFact = $row["nrFact"];
            }
        }
        $maxNrFact++;

        $dataEmit = date("Y-m-d");
        $dataScad = date('Y-m-d', strtotime("+30 days"));
        
        $cui = $_SESSION["selected_furn_mod"];
        $codProd = $_POST["prd_sel"];

        $cantAprov = floatval($_POST["cant"]);
        $pretAchiz = $_POST["pret"];

        mysqli_query($conectare, "INSERT INTO factura (nrFact, dataEmitere, dataScadenta, CUI) VALUES ($maxNrFact, '$dataEmit', '$dataScad', '$cui')");
        mysqli_query($conectare, "INSERT INTO aprovizionare (nrFact, codProdus, cantitateAprov, pretAchiz) VALUES ($maxNrFact, $codProd, $cantAprov, $pretAchiz)");
        mysqli_query($conectare, "UPDATE produs SET stoc=stoc+$cantAprov WHERE codProdus=$codProd");

    } else if(isset($_GET["actionare"]) && $_GET["actionare"] == "select"){

        if(isset($_SESSION["selected_cat_mod"])){
            $_SESSION["selected_furn_mod"] = $_GET["furn_sel"];
            $_SESSION["selected_cat_mod"] = $_GET["cat_sel"];
        } else {
            $_SESSION["selected_furn_mod"] = "";
            $_SESSION["selected_cat_mod"] = "";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovizionare</title>
</head>
<body>
    <h1>Aprovizionare</h1>

    <div>
        <form action="aprovizionare.php" method="GET">
            <label>Furnizori : </label>
            <select name="furn_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT CUI, denumireF FROM furnizor");
                    while($row=mysqli_fetch_array($fill)) {
                        if($_SESSION["selected_furn_mod"] == $row["CUI"]) {
                            $stat = "selected";
                        } else { $stat = ""; }
	                    echo "<option value='".$row["CUI"]."' $stat>".$row["denumireF"]."</option>";
                    }
                ?>
            </select><br>

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
        <form action="aprovizionare.php" method="POST">
            <label>Produsul : </label>
            <select name="prd_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs WHERE codC='".$_SESSION["selected_cat_mod"]."'");
                    while($row=mysqli_fetch_array($fill)) {
	                    echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
                    }
                ?>
            </select><br>
            <label>Cantitate : </label><input type="text" name="cant" /><label> Kg</label><br>
            <label>Pret achizitie : </label><input type="text" name="pret" /><label> Ron</label><br><br>
            <button type="submit" name="actionare" value="aprov">Aprovioneaza</button>
        </form>
    </div><br>

    <div class="container">
        <table>
            <tr>
                <th colspan="2">Nr. aprovizionari / furnizor [30 zile]</th>
            </tr>
            <?php
                $data_start = date('Y-m-d', strtotime("-30 days"));
                $data_end = date('Y-m-d');

                $select = mysqli_query($conectare, "SELECT CUI, COUNT(nrFact) as maxfact FROM factura WHERE '$data_start' <= dataEmitere AND dataEmitere <= '$data_end' GROUP BY CUI ORDER BY maxfact DESC LIMIT 10");

                while($row=mysqli_fetch_array($select)) {
                    $prd = mysqli_fetch_array(mysqli_query($conectare, "SELECT denumireF FROM furnizor WHERE CUI='".$row["CUI"]."'"));
                    echo "<tr>
                        <td>".$prd["denumireF"]."</td>
                        <td>".$row["maxfact"]."</td>
                    </tr>";
                }
            ?>
        </table>
    </div>
    
    <form action="aprovizionare.php" method="POST">
        <button type="submit" name="back" value="back">back</button>
    </form>
</body>
</html>