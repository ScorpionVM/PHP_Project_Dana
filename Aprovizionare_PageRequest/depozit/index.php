<?php
    include("../conectare.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depozit</title>
</head>
<body>
    <h1>Depozit</h1>
    <p>Verifica depozit per categorie la produse in stare de epuizare [<20KG] </p>
    <form action="depozit.php" method="GET">
        <label>Categoria : </label>
        <select name="cat_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                while($row=mysqli_fetch_array($fill)) {
                    echo "<option value='".$row["codC"]."' >".$row["denumire"]."</option>";
                }
            ?>
        </select>
        <button type="submit" name="actionare" value="verif">Verifica</button>
    </form>
    
    
    <br>
	<a href="../index.php">Back</a>
</body>
</html>