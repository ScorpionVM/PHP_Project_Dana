<?php
    session_start();
    include("conectare.php");

    if(!isset($_SESSION["selected_cat"])){ $_SESSION["selected_cat"] = ""; }
    
    if(isset($_POST["back"]) && ($_POST["back"] == "back")){
        header("Location: index.php");
    } 
    
    if(isset($_POST["actionare"]) && ($_POST["actionare"] == "adauga")){
        $select = mysqli_query($conectare, "SELECT codProdus FROM produs");
        $max = 0;
        while($row=mysqli_fetch_array($select)){
            if ($max < $row["codProdus"]){
                $max = $row["codProdus"];
            }
        }
        $max++;
        $denP = $_POST["den"];
        $desc = $_POST["desc"];
        $codC = $_POST["cat_sel"];
        mysqli_query($conectare, "INSERT INTO produs (codProdus, denumireProdus, UM, descriere, codC, stoc) VALUES($max, '$denP', 'kg', '$desc', $codC, 0.0)");
        
    } else if(isset($_GET["actionare"])){
        if($_GET["actionare"] == "select") {
            if (isset($_SESSION["selected_cat"])) {
                $_SESSION["selected_cat"] = $_GET["cat_sel"];
            } else {
                $_SESSION["selected_cat"] = "";
            }
        } else if ($_GET["actionare"] == "sterge") {
            mysqli_query($conectare, "DELETE FROM produs WHERE codProdus='".$_GET["prd_sel"]."'");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produse</title>
</head>
<body>
    <h1>Produse</h1>
    
    <div>
        <h3>Adauga produs nou</h3>
        <form action="produse.php" method="POST">
            <label>Denumire produs: </label><input type="text" name="den" required /><br>
            <label>Unitatea de masura:</label><input type="text" name="um" value="KG" disabled /><br>
            <label>Descriere produs: </label><input type="text" name="desc" required/><br>
            <label>Categorie: </label>
            <select name="cat_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                    while($row=mysqli_fetch_array($fill)) {
	                    echo "<option value='".$row["codC"]."'>".$row["denumire"]."</option>";
                    }
                ?>
            </select>

            <button type="submit" name="actionare" value="adauga">Adauga</button>
        </form>
    </div>

    <div>
        <h3>Sterge produs</h3>
        <form action="produse.php" method="GET">
            <label>Categorie:</label>
            <select name="cat_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                    while($row=mysqli_fetch_array($fill)) {
                        if($_SESSION["selected_cat"] == $row["codC"]) {
                            $stat = "selected";
                        } else { $stat = ""; }
	                    echo "<option value='".$row["codC"]."' $stat>".$row["denumire"]."</option>";
                    }
                ?>
            </select>

            <button type="submit" name="actionare" value="select">Select</button>
        </form>

        <form action="produse.php" method="GET">
            <label>Produse:</label>
            <select name="prd_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs WHERE codC='".$_SESSION["selected_cat"]."'");
                    while($row=mysqli_fetch_array($fill)) {
	                    echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
                    }
                ?>
            </select>

            <button type="submit" name="actionare" value="sterge">Sterge</button>
        </form>
    </div><br>
    <div>
        <h3>Modifica produs</h3>
        <form action="produse.php" method="GET">
            <label>Categorie</label>
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
        <form action="produse.php" method="POST">
            <label>Produse</label>
            <select name="prd_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs WHERE codC='".$_SESSION["selected_cat_mod"]."'");
                    while($row=mysqli_fetch_array($fill)) {
                        echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
                    }
                ?>
            </select><br>

            <?php
                if(isset($_SESSION["selected_cat_mod"]) && $_SESSION["selected_cat_mod"] != ""){
                    $fill = mysqli_query($conectare, "SELECT denumireProdus, descriere FROM produs WHERE codC=".$_SESSION["selected_cat_mod"]); 
                    $row = mysqli_fetch_array($fill);
                    $old_den = $row["denumireProdus"];
                    $old_desc = $row["descriere"];
                } else {
                    $old_den = ""; $old_desc = "";
                }
            ?>

            <label>Denumire noua</label><input type="text" name="denN" value="<?= $old_den ?>" required/><br>
            <label>Descriere noua</label><input type="text" name="desc" value="<?= $old_desc ?>" required/><br><br>
            <button type="submit" name="actionare" value="modifica">Modifica</button>
        </form>
    </div><br>

    <div>
        <form action="produse.php" method="POST">
            <button type="submit" name="back" value="back">back</button>
        </form>
    </div>
</body>
</html>