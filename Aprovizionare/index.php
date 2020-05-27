<?php
    if(isset($_POST["goto"])){
        if($_POST["goto"] == "aprov"){
            header("Location: /aprovizionare.php");
        } else if($_POST["goto"] == "categ"){
            header("Location: /categorii.php");
        } else if($_POST["goto"] == "prods"){
            header("Location: /produse.php");
        } else if($_POST["goto"] == "consum"){ 
            header("Location: /consum.php");
        } else if($_POST["goto"] == "furnz"){
            header("Location: /furnizori.php");
        } else if($_POST["goto"] == "depozit"){
            header("Location: /depozit.php");
        } 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chocolate Mania SRL</title>
</head>
<body>
    <h1>Chocolate Mania SRL</h1>
    <h3>Meniu</h3>
    <div>
        <form action="/" method="POST">
            <button type="submit" name="goto" value="aprov">Aprovizionare</button>
            <button type="submit" name="goto" value="consum">Consum</button>
            <button type="submit" name="goto" value="depozit">Depozit</button>
            <br><br>
            <button type="submit" name="goto" value="categ">Categorii</button>
            <button type="submit" name="goto" value="prods">Produse</button>
            <button type="submit" name="goto" value="furnz">Furnizori</button>
        </form>
    </div>
</body>
</html>