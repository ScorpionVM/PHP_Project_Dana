<?php
    session_start();
    include("conectare.php");

    if(isset($_SESSION["cat_sel_mod"]) && $_SESSION["cat_sel_mod"] == "") {
        $_SESSION["cat_sel_mod"] = "";
    }


	if (isset($_POST["actionare"]) && $_POST["actionare"] == "aprov") {

		$select = mysqli_query($conectare, "SELECT nrFact FROM factura");
        $maxNrFact = 0;
        while($row=mysqli_fetch_array($select)){
            if ($maxNrFact < $row["nrFact"]){
                $maxNrFact = $row["nrFact"];
            }
        }
        $maxNrFact++;

        $dataEmit = date("Y-m-d");
        $dataScad = date('Y-m-d', strtotime("+30 days"));
        
        $cui = $_POST["furn_sel"];
        $codProd = $_POST["prd_sel"];

        $cantAprov = floatval($_POST["cant"]);
        $pretAchiz = $_POST["pret"];

        mysqli_query($conectare, "INSERT INTO factura (nrFact, dataEmitere, dataScadenta, CUI) VALUES ($maxNrFact, '$dataEmit', '$dataScad', '$cui')");
        mysqli_query($conectare, "INSERT INTO aprovizionare (nrFact, codProdus, cantitateAprov, pretAchiz) VALUES ($maxNrFact, $codProd, $cantAprov, $pretAchiz)");
        mysqli_query($conectare, "UPDATE produs SET stoc=stoc+$cantAprov WHERE codProdus=$codProd");

	} else if(isset($_GET["actionare"]) && $_GET["actionare"] == "select") {
		$_SESSION["cat_sel_mod"] = $_GET["cat_sel"];
    }

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

    <form action="aprov_test.php" method="GET">
        <label>Categoria : </label>
        <select name="cat_sel">
            <?php
                $select = mysqli_query($conectare, "SELECT codC, denumire FROM categorie");
                while($row=mysqli_fetch_array($select)) {      

                    if($_SESSION["cat_sel_mod"] == $row["codC"]) {
                        $stat = "selected";
                    } else { $stat = ""; }

                    echo "<option value='".$row["codC"]."' $stat>".$row["denumire"]."</option>";
                }
            ?>
        </select>
        <button type="submit" name="actionare" value="select">Select</button>
    </form>

    <form action="aprov_test.php" method="POST">
		<label>Produs : </label>
		<select name="prd_sel">
			<?php
				$select = mysqli_query($conectare, "SELECT codProdus, denumireProdus FROM produs WHERE codC=".$_SESSION["cat_sel_mod"]);
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

	<form action="aprovizionare.php" method="POST">
        <button type="submit" name="back" value="back">back</button>
    </form>

</body>
</html>