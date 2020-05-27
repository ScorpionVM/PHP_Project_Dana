<?php
    session_start();

    include("conectare.php");
    include("layouts.php");


    if(isset($_POST["back"]) && ($_POST["back"] == "back")){
        header("Location: index.php");
    }

    if(!isset($_SESSION["selected_cat_mod"])) {
        $_SESSION["selected_cat_mod"] = "";
    }
    
    if(isset($_POST["actionare"])) {

        if($_POST["actionare"] == "adauga"){
            $select = mysqli_query($conectare, "SELECT codC FROM categorie");
            $max = 0;
            while($row=mysqli_fetch_array($select)){
                if ($max < $row["codC"]){
                    $max = $row["codC"];
                }
            }
            $max++;
            $den = $_POST["den"];
            $desc = $_POST["desc"];

            mysqli_query($conectare, "INSERT INTO categorie (codC, denumire, descriere) VALUES ($max, '$den', '$desc')");
        } else if($_POST["actionare"] == "modifica"){            
            mysqli_query($conectare, "UPDATE categorie SET denumire='".$_POST["denN"]."', descriere='".$_POST["desc"]."' WHERE codC='".$_POST["cat_sel"]."'");    
            $_SESSION["selected_cat_mod"] = "";
        }

    } else if(isset($_GET["actionare"])){

        if($_GET["actionare"] == "select"){

            if(isset($_SESSION["selected_cat_mod"])){
                $_SESSION["selected_cat_mod"] = $_GET["cat_sel"];
            } else {
                $_SESSION["selected_cat_mod"] = "";
            }

        } else if($_GET["actionare"] == "cauta"){
            
            $select = mysqli_query($conectare, "SELECT denumire FROM categorie WHERE denumire='".$_GET["cauta_den"]."'");
            if(mysqli_num_rows($select) > 0){
                echo "Categoria: ".$_GET["cauta_den"]." a fost gasita!";
            } else {
                echo "Categoria: ".$_GET["cauta_den"]." nu a fost gasita!";
            }
        
        } else if($_GET["actionare"] == "sterge"){
            
            mysqli_query($conectare, "DELETE FROM categorie WHERE codC='".$_GET["cat_sel"]."'");
        
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorii</title>

    <link rel="stylesheet" href="./styles/nav_menu.css">
    <link rel="stylesheet" href="./styles/index.css">

</head>
<body>
    <div class="page"> 
        <?= $NAV_MENU ?>
    
        <div class="in-screen">
            <h1>Gestionare Categorii</h1>
            <div class="in-row">
                <div class="container">
                    <h3>Adauga o categorie noua</h3>
                    <form action="categorii.php" method="POST">
                        <label>Denumire</label><input type="text" name="den" /><br>
                        <label>Descriere</label><input type="text" name="desc" /><br><br>
                        <button type="submit" name="actionare" value="adauga">Adauga</button>
                    </form>
                </div>
                
                <div class="container">
                    <h3>Modifica categorie</h3>
                    <form action="categorii.php" method="GET">
                        <label>Categorii</label>
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
                    <form action="categorii.php" method="POST">
                        <?php
                            if(isset($_SESSION["selected_cat_mod"]) && $_SESSION["selected_cat_mod"] != ""){
                                $fill = mysqli_query($conectare, "SELECT denumire, descriere FROM categorie WHERE codC=".$_SESSION["selected_cat_mod"]); 
                                $row = mysqli_fetch_array($fill);
                                $old_den = $row["denumire"];
                                $old_desc = $row["descriere"];
                            } else {
                                $old_den = ""; $old_desc = "";
                            }
                        ?>

                        <label>Denumire noua</label><input type="text" name="denN" value="<?= $old_den ?>"/><br>
                        <label>Descriere noua</label><input type="text" name="desc" value="<?= $old_desc ?>"/><br><br>
                        <button type="submit" name="actionare" value="modifica">Modifica</button>
                    </form>
                </div>
            </div>
            <div class="in-row">
                <div class="container">
                    <h3>Cauta categorie</h3>
                    <form action="categorii.php" method="GET">
                        <label>Nume Categorie</label><input type="text" name="cauta_den" />
                        <button type="submit" name="actionare" value="cauta">Cauta</button>
                    </form>
                </div>
                
                <div class="container">
                    <h3>Sterge categorie</h3>
                    <form action="categorii.php" method="GET">
                        <label>Categorie</label>
                        <select name="cat_sel">
                            <?php
                                $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                                while($row=mysqli_fetch_array($fill)) {
                                    echo "<option value='".$row["codC"]."'>".$row["denumire"]."</option>";
                                }
                            ?>
                        </select>
                        <button type="submit" name="actionare" value="sterge">Sterge</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>