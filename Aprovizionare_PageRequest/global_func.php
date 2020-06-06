<?php
    function ifnull($x, $y){

        if($x != $y && $x != '') {
            echo "<br>- For update `$x` -> `$y`<br>";
        }

        if($x == ''){
            return $y;
        } else {
            return $x;
        }
    }
?>