<?php
    session_start();

    include("../conectare.php");

    if(isset($_GET["actionare"]) && $_GET["actionare"] == "cauta"){        
        $select = mysqli_query($conectare, "SELECT codC, denumire, descriere  FROM categorie WHERE denumire='".$_GET["cauta_den"]."'");
        if(mysqli_num_rows($select) > 0){
            echo "Categoria: ".$_GET["cauta_den"]." a fost gasita!<br>";
            
            while($row=mysqli_fetch_array($select)){
                $cod = $row["codC"];
                $den = $row["denumire"];
                $desc = $row["descriere"];
            }

            echo "Date categorie:<br>Cod : $cod<br>Denumire : $den<br>Descriere : $desc<br>";
        
        } else {
            echo "Categoria: ".$_GET["cauta_den"]." nu a fost gasita!<br>";
        }
    }
?>

<body>
    <a href="./index.php">Back</a>
</body>