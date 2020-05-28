<?php
    session_start();
    include("conectare.php");

    if(!isset($_SESSION["cat_sel_mod"])) {
        $_SESSION["cat_sel_mod"] = "";
    }

    if(isset($_POST["back"]) && ($_POST["back"] == "back")){
        header("Location: index.php");
    }

    if(isset($_GET["actionare"]) && $_GET["actionare"] == "show"){
        if(isset($_SESSION["cat_sel_mod"])){
            $_SESSION["cat_sel_mod"] = $_GET["cat_sel"];
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Depozit</h1>
    <p>Afisare produse in catitate de risc < 20 kg</p>
    <form action="depozit.php" method="GET">
        <label>Per categoir : </label>
        <select name="cat_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                while($row=mysqli_fetch_array($fill)) {
                    if(isset($_SESSION["cat_sel_mod"]) && $_SESSION["cat_sel_mod"] == $row["codC"]) {
                        $stat = "selected";
                    } else {
                        $stat = "";
                    }
                    echo "<option value='".$row["codC"]."' $stat>".$row["denumire"]."</option>";
                }
            ?>
        </select>
        <button type="submit" name="actionare" value="show">Show</button>
    </form><br>
    <div>        
        <?php
            $select = mysqli_query($conectare, "SELECT denumireProdus, stoc FROM produs WHERE stoc <= 20 AND codC=".$_SESSION["cat_sel_mod"]);
            if( mysqli_num_rows($select) > 0) {
                echo "<table border>
                <tr>
                    <th colspan='2'>Lista produse</th>
                </tr>";
                while($row=mysqli_fetch_array($select)) {
                    echo "<tr>
                        <td>".$row["denumireProdus"]."</td>
                        <td>".$row["stoc"]."</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Categoria data nu contine produse cu cantitatea mai mica de 20 Kg</p>";
            }
        ?>
    </div><br><br>

    <form action="depozit.php" method="POST">
        <button type="submit" name="back" value="back">back</button>
    </form>
</body>
</html>