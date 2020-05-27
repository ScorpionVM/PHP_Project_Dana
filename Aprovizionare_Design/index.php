<?php
    session_start();
    include("layouts.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chocolate Mania SRL</title>

    <link rel="stylesheet" href="./styles/nav_menu.css">
    <link rel="stylesheet" href="./styles/index.css">
</head>
<body>
    <div class="page"> 
        <?= $NAV_MENU ?>
    
        <div class="in-screen">
            <h1>Chocolate Mania SRL</h1>
        </div>
    </div>
</body>
</html>