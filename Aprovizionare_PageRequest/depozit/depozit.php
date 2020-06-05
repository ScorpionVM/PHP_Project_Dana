<?php
    include("../conectare.php");

    if(isset($_GET["actionare"]) && $_GET["actionare"] == "verif"){

        $select = mysqli_query($conectare, "SELECT denumireProdus, stoc FROM produs WHERE stoc <= 20 AND codC=".$_GET["cat_sel"]);
        if( mysqli_num_rows($select) > 0) {

            echo "<p>Lista produse :</p>";

            echo "<table border>
                <tr><td>Denumire produse</td><td>Kg</td></tr>";
            while($row=mysqli_fetch_array($select)) {
                echo "<tr>
                    <td>".$row["denumireProdus"]."</td>
                    <td>".$row["stoc"]."</td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Categoria data nu contine produse cu cantitati mai mici de 20 Kg</p>";
        }
    }
?>

<body>
    <br>
    <a href="./index.php">Back</a>
</body>