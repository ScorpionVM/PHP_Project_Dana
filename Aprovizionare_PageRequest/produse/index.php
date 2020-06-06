<?php
    include("../conectare.php");
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
    
    <h3>Adauga produs nou</h3>
    <form action="./adauga_produs.php" method="POST">
        <label>Denumire produs : </label><input type="text" name="den" required /><br>
        <label>Unitatea de masura : </label><input type="text" name="um" value="KG" disabled /><br>
        <label>Descriere produs : </label><input type="text" name="desc" required /><br>
        <label>Categorie : </label>
        <select name="cat_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                while($row=mysqli_fetch_array($fill)) {
                    echo "<option value='".$row["codC"]."'>".$row["denumire"]."</option>";
                }
            ?>
        </select><br>
        <label>Termen valabilitate : </label><input type="text" name="term" required/><label> zile</label>
        <button type="submit" name="actionare" value="adauga">Adauga</button>
    </form>


    <h3>Modifica produs</h3>
    <form action="./modifica_produs.php" method="GET">
        <label>Produse : </label>
        <select name="prd_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs");
                while($row=mysqli_fetch_array($fill)) {
                    echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
                }
            ?>
        </select><br>

        <label>Denumire noua : </label><input type="text" name="denN" /><br>
        <label>Descriere noua : </label><input type="text" name="desc" /><br><br>
        <button type="submit" name="actionare" value="modifica">Modifica</button>
    </form><br>

    <h3>Sterge produs</h3>
    <form action="./sterge_produs.php" method="GET">
        <label>Produs : </label>
        <select name="prd_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs");
                while($row=mysqli_fetch_array($fill)) {
                    echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
                }
            ?>
        </select>
        <button type="submit" name="actionare" value="sterge">Sterge</button>
    </form>
    
    <br>
	<a href="../index.php">Back</a>
</body>
</html>