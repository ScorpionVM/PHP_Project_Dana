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
        } else if ($_POST["goto"] == "depozit") {
            header("Location: /depozit.php");
        }
    }

    $NAV_MENU = "<div class='side-align'>    
        <div class='side-nav-bar'>
            <div class='nav-header'>Menu</div>
            <form action='/' method='POST'>
                <button class='btn-nav' type='submit' name='goto' value='aprov'>Aprovizionare</button><br>
                <button class='btn-nav' type='submit' name='goto' value='categ'>Categorii</button><br>
                <button class='btn-nav' type='submit' name='goto' value='depozit'>Depozit</button><br>
                <button class='btn-nav' type='submit' name='goto' value='categ'>Categorii</button><br>
                <button class='btn-nav' type='submit' name='goto' value='prods'>Produse</button><br>
                <button class='btn-nav' type='submit' name='goto' value='furnz'>Furnizori</button>
            </form>
        </div>
    </div>";
?>

