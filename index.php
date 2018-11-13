<?php

function add($x, $y) {
    $suma = $x + $y;
    print "$x + $y suma: " . $suma;
}
?>
<html>
    <head>
        <style>

        </style>
    </head>
    <body>
        <h1><?php add(3, 5); ?></h1>
    </body>
</html>