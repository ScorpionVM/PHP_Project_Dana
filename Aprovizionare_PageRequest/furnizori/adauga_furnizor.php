<?php
    include("../conectare.php");

    if(isset($_POST["actionare"]) && $_POST["actionare"] == "adauga") {
        $cui = $_POST["cui"];
        $denF = $_POST["denF"];
        $telefon = $_POST["tel"];
        $email = $_POST["email"];

        $banca = $_POST["banca"];
        
        $idAdresa = mysqli_fetch_array(mysqli_query($conectare, "SELECT MAX(idAdresa) as maxIA FROM adresa"))["maxIA"] + 1;
        $localitate = $_POST["localitate"];
        $judet = $_POST["judet"];
        $strd = $_POST["strad"];
        $nr = $_POST["nr"];
        $codPost = $_POST["codPostal"];

        mysqli_query($conectare, "INSERT INTO furnizor(CUI, denumireF, email, telefon) VALUES ('$cui', '$denF', '$telefon', '$email')");
        mysqli_query($conectare, "INSERT INTO furnizorcont(SWIFT, CUI) VALUES ('$banca', '$cui')");
        mysqli_query($conectare, "INSERT INTO adresa(idAdresa, denumireJudet, denumireLocalitate, denumireStrada, numar, codPostal, CUI) VALUES ($idAdresa, '$judet', '$localitate', '$strd', '$nr', $codPost, '$cui')");
        echo "<p>Furnizor adaugat cu succes!</p>";
    }
?>
<body>
    <br>
    <a href="./index.php">Back</a>
</body>