<?php
    session_start();

    include("conectare.php");

    if(isset($_POST["back"]) && ($_POST["back"] == "back")){
        header("Location: index.php");
    }
    
    if(isset($_POST["actionare"])) {

        if($_POST["actionare"] == "adauga"){
            $cui = $_POST["CUI"];
            $denF = $_POST["denF"];
            $telefon = $_POST["tel"];
            $email = $_POST["email"];

            mysqli_query($conectare, "INSERT INTO furnizor(CUI, denumireF, email, telefon) VALUES ('$cui', '$denF', '$telefon', '$email')");
        } else if($_POST["actionare"] == "modifica"){   
            
            $denF = $_POST["denF"];
            $telefon = $_POST["tel"];
            $email = $_POST["email"];            
            
            mysqli_query($conectare, "UPDATE furnizor SET denumireF='$denF', email='$email', telefon='$telefon' WHERE CUI='".$_SESSION["selected_furn_mod"]."'");
            $_SESSION["selected_furn_mod"] = "";
               
        }

    } else if(isset($_GET["actionare"])){

        if($_GET["actionare"] == "select"){

            if(isset($_SESSION["selected_furn_mod"])){
                $_SESSION["selected_furn_mod"] = $_GET["furn_sel"];
            } else {
                $_SESSION["selected_furn_mod"] = "";
            }

            echo "Selected ".$_SESSION["selected_furn_mod"];

        } else if($_GET["actionare"] == "sterge"){
            
            mysqli_query($conectare, "DELETE FROM furnizor WHERE CUI='".$_GET["furn_sel"]."'");
        
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furnizori</title>
</head>
<body>
    <h1>Gestionare Furnizori</h1>

    <div>
        <h3>Inregistreaza un furnizor nou</h3>
        <form action="furnizori.php" method="POST">
            <label>CUI : </label><input type="text" name="cui" /><br>
            <label>Denumire Furnizor : </label><input type="text" name="denF" /><br>
            <label>Telefon : </label><input type="text" name="tel" /><br>
            <label>E-mail : </label><input type="text" name="email" /><br>
            <button type="submit" name="actionare" value="adauga">Adauga</button>
        </form>
    </div>
    
    <div>
        <h3>Modifica date furnizor</h3>
        <form action="furnizori.php" method="GET">
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
            </select>
            <button type="submit" name="actionare" value="select">Select</button>
        </form>

        <form action="furnizori.php" method="POST">
            <?php
                if(isset($_SESSION["selected_furn_mod"]) && $_SESSION["selected_furn_mod"] != ""){
                    $fill = mysqli_query($conectare, "SELECT denumireF, telefon, email FROM furnizor WHERE CUI='".$_SESSION["selected_furn_mod"]."'"); 
                    $row = mysqli_fetch_array($fill);
                    $old_den = $row["denumireF"];
                    $old_tel = $row["telefon"];
                    $old_email = $row["email"];
                } else {
                    $old_den = ""; $old_tel = ""; $old_email = "";
                }
            ?>

            <label>Denumire noua : </label><input type="text" name="denF" value="<?= $old_den ?>" required/><br>
            <label>Telefon nou : </label><input type="text" name="tel" value="<?= $old_tel ?>" required><br>
            <label>Email nou : </label><input type="text" name="email" value="<?= $old_email ?>" required><br>
            <button type="submit" name="actionare" value="modifica">Modifica</button>
        </form>
    </div>

    <div>
        <h3>Sterge furnizor</h3>
        <form action="furnizori.php" method="GET">
            <label>Sterge Furnizor : </label>
            <select name="furn_sel">
                <?php
                    $fill = mysqli_query($conectare, "SELECT CUI, denumireF FROM furnizor");
                    while($row=mysqli_fetch_array($fill)) {
	                    echo "<option value='".$row["CUI"]."'>".$row["denumireF"]."</option>";
                    }
                ?>
            </select>
            <button type="submit" name="actionare" value="sterge">Sterge</button>
        </form>
    </div><br>

    <form action="furnizori.php" method="POST">
        <button type="submit" name="back" value="back">back</button>
    </form>
</body>
</html>