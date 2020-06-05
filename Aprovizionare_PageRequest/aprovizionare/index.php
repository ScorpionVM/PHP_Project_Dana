<?php
    include("../conectare.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovizionare</title>
</head>
<body> 
    <h1>Aprovizionare</h1>

    <form action="./aprovizionare.php" method="POST">
		<label>Produs : </label>
		<select name="prd_sel">
			<?php
				$select = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs");
				while($row=mysqli_fetch_array($select)) {      
					echo "<option value='".$row["codProdus"]."'>".$row["denumireProdus"]."</option>";
				}
			?>
		</select><br>

		<label>Cantitate : </label><input type="text" name="cant" /><label> KG</label><br>
		<label>Pret : </label><input type="text" name="pret" /><label> RON</label><br>
		<label>Furnizori : </label>
        <select name="furn_sel">
            <?php
                $select = mysqli_query($conectare, "SELECT CUI, denumireF FROM furnizor");
                while($row = mysqli_fetch_array($select)){

                    echo "<option value='".$row["CUI"]."'>".$row["denumireF"]."</option>";
                }
            ?>
        </select><br><br>

		<button type="submit" name="actionare" value="aprov">Aprovizioneaza</button>
    </form>

	<br><br>

	<table border>
		<tr>
			<th colspan="2">Nr. aprovizionari / furnizor [30 zile]</th>
		</tr>
		
		<?php
			$data_start = date('Y-m-d', strtotime("-30 days"));
			$data_end = date('Y-m-d');

			$select = mysqli_query($conectare, "SELECT CUI, COUNT(nrFact) as maxfact FROM factura WHERE '$data_start' <= dataEmitere AND dataEmitere <= '$data_end' GROUP BY CUI ORDER BY maxfact DESC LIMIT 10");

			while($row=mysqli_fetch_array($select)) {
				$prd = mysqli_fetch_array(mysqli_query($conectare, "SELECT denumireF FROM furnizor WHERE CUI='".$row["CUI"]."'"));
				echo "<tr>
					<td>".$prd["denumireF"]."</td>
					<td>".$row["maxfact"]."</td>
				</tr>";
			}
		?>
	</table><br>

	<a href="../index.php">Back</a>
</body>
</html>