<?php
    include("../conectare.php");

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

        echo "<p><b></b>Aprovizionat cu succes!</b></p><p>Pentru produsul '$codProd' au fost adaugate +$cantAprov KG</p>";
	}
?>

<body>
    <a href="./index.php">Back</a>
</body>