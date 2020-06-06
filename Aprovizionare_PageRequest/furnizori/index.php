<?php
    include("../conectare.php");
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

    <h3>Inregistreaza un furnizor nou</h3>
    <form action="./adauga_furnizor.php" method="POST">
        <label>CUI : </label><input type="text" name="cui" /><br>
        <label>Denumire Furnizor : </label><input type="text" name="denF" /><br>
        <label>Telefon : </label><input type="text" name="tel" /><br>
        <label>E-mail : </label><input type="email" name="email" /><br><br>

        <label>Banca : </label>
        <select name="banca">
            <?php
                $select = mysqli_query($conectare, "SELECT swift, denumireBanca FROM banca");
                while($fill=mysqli_fetch_array($select)){
                    echo "<option value='".$fill["swift"]."'>".$fill["denumireBanca"]."</option>";
                }
            ?>
        </select><br><br>

        <label>Localitate : </label><input type="text" name="localitate" /><br>
        <label>Judet : </label><input type="text" name="judet" /><br>
        <label>Strada : </label><input type="text" name="strad" />
        <label> nr </label><input type="text" name="nr" /><br>
        <label>Cod Postal : </label><input type="text" name="codPostal" />
        <br><br>
        <button type="submit" name="actionare" value="adauga">Adauga</button>
    </form>

    <h3>Modifica date furnizor</h3>
    <form action="./modifica_furnizor.php" method="GET">
        <label>Furnizor : </label>
        <select name="furn_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT CUI, denumireF FROM furnizor");
                while($row=mysqli_fetch_array($fill)) {
                    echo "<option value='".$row["CUI"]."'>".$row["denumireF"]."</option>";
                }
            ?>
        </select><br>

        <label>Denumire noua : </label><input type="text" name="denF" /><br>
        <label>Telefon nou : </label><input type="text" name="tel" /><br>
        <label>Email nou : </label><input type="text" name="email" /><br>

        <label>Localitate : </label><input type="text" name="localitate" /><br>
        <label>Judet : </label><input type="text" name="judet" /><br>
        <label>Strada : </label><input type="text" name="strad" />
        <label> nr </label><input type="text" name="nr" /><br>
        <label>Cod Postal : </label><input type="text" name="codpostal" />
        <br><br>
        <button type="submit" name="actionare" value="modifica">Modifica</button>
    </form>

    <h3>Sterge furnizor</h3>
    <form action="./sterge_furnizor.php" method="GET">
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
    
    
    <br>
	<a href="../index.php">Back</a>
</body>
</html>