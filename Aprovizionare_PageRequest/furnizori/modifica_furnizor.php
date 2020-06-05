<?php
    include("../conectare.php");
    include("../global_func.php");

    if(isset($_GET["actionare"]) && $_GET["actionare"] == "modifica"){   

        $cui = $_GET["furn_sel"];

        # date din baza de date

        $date_furnizor = mysqli_fetch_array(mysqli_query($conectare, "SELECT denumireF, email, telefon FROM furnizor WHERE CUI='$cui'"));
        $old_den = $date_furnizor["denumireF"];
        $old_email = $date_furnizor["email"];
        $old_telefon = $date_furnizor["telefon"];

        $date_adresa = mysqli_fetch_array(mysqli_query($conectare, "SELECT * FROM adresa WHERE CUI='$cui'"));
        $old_localitate = $date_adresa["denumireLocalitate"];
        $old_judet = $date_adresa["denumireJudet"];
        $old_strd = $date_adresa["denumireStrada"];
        $old_nr = $date_adresa["numar"];
        $old_codPostal = $date_adresa["codPostal"]; 

        # date din form

        $denF = ifnull($_GET["denF"], $old_den);
        $telefon = ifnull($_GET["tel"], $old_telefon);
        $email = ifnull($_GET["email"], $old_email);            
        
        $new_localitate = ifnull($_GET["localitate"], $old_localitate);
        $new_judet = ifnull($_GET["judet"], $old_judet);
        $new_strd = ifnull($_GET["strad"], $old_strd);
        $new_nr = ifnull($_GET["nr"], $old_nr);
        $new_codPostal = ifnull($_GET["codPostal"], $old_codPostal);

        mysqli_query($conectare, "UPDATE furnizor SET denumireF='$denF', email='$email', telefon='$telefon' WHERE CUI='$cui'");
        mysqli_query($conectare, "UPDATE adresa SET denumireJudet='$new_judet', denumireLocalitate='$new_localitate', denumireStrada='$new_strd', numar='$new_nr', codPostal=$new_codPostal WHERE cui='$cui'");
        
        echo "<p>Valorile noi pentru furnizorul '$old_den' sunt:<br><br>Denumire: '$old_den' -> '$denF'<br>Telefon: '$old_telefon' -> '$telefon'<br>E-mail: '$old_email' -> '$email'<br></p>";
    }
?>
<body>
    <br>
    <a href="./index.php">Back</a>
</body>