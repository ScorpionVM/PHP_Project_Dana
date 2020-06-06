<?php
    include("../conectare.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorii</title>
</head>
<body>
    <h1>Gestionare Categorii</h1>

    <h3>Adauga o categorie noua</h3>
    <form action="./adauga_categorie.php" method="POST">
        <label>Denumire : </label><input type="text" name="den" required/><br>
        <label>Descriere : </label><input type="text" name="desc" required/><br>
        <button type="submit" name="actionare" value="adauga">Adauga</button>
    </form>

    <h3>Modifica categorie</h3>
    <form action="./modifica_categorie.php" method="POST">
        <label>Categorie : </label>
        <select name="cat_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                while($row=mysqli_fetch_array($fill)) {
                    echo "<option value='".$row["codC"]."'>".$row["denumire"]."</option>";
                }
            ?>
        </select><br>

        <label>Denumire noua : </label><input type="text" name="denN" /><br>
        <label>Descriere noua : </label><input type="text" name="desc" /><br>
        <button type="submit" name="actionare" value="modifica">Modifica</button>
    </form>

    <h3>Cauta categorie</h3>
    <form action="./cauta_categorie.php" method="GET">
        <label>Cauta : </label><input type="text" name="cauta_den" />
        <button type="submit" name="actionare" value="cauta">Cauta</button>
    </form>

    <h3>Sterge categorie</h3>
    <form action="./sterge_categorie.php" method="GET">
        <label>Categorie : </label>
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
    
    <br>
    <a href="../index.php">Back</a>
</body>
</html>