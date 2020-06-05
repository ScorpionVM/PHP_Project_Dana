<?php
    function ifnull($x, $y){
        if($x == ''){
            return $y;
        } else {
            return $x;
        }
    }
?>