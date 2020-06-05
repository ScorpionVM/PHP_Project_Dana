<?php
    include_once("../conectare.php");
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
    
    <form action="./consum.php" method="POST">
        <label>Produsul : </label>
        <select name="prd_sel">
            <?php
                $fill = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs");
                while($row=mysqli_fetch_array($fill)) {
                    echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
                }
            ?>
        </select><br>
        <label>Cantitate Consumata : </label><input type="text" name="cant" required /><label> Kg</label><br><br>
        <button type="submit" name="actionare" value="cons">Consuma</button>
    </form>
    <br>

    <table border>
        <tr>
            <td colspan="2">Top 10 consumari in ultimile 30 zile</td>
        </tr>
        <?php
            $data_start = date('Y-m-d', strtotime("-30 days"));
            $data_end = date('Y-m-d');

            $select = mysqli_query($conectare, "SELECT codProdus, SUM(cantitate) as maxcons FROM consumare WHERE '$data_start' <= dataCons AND dataCons <= '$data_end' GROUP BY codProdus ORDER BY maxcons DESC LIMIT 10");

            while($row=mysqli_fetch_array($select)) {
                $prd = mysqli_fetch_array(mysqli_query($conectare, "SELECT denumireProdus FROM produs WHERE codProdus=".$row["codProdus"]));
                echo "<tr>
                    <td>".$prd["denumireProdus"]."</td>
                    <td>".$row["maxcons"]."</td>
                </tr>";
            }
        ?>
    </table>
    <br>

	<a href="../index.php">Back</a>
</body>
</html>