<?php
$liepa_days = 31;
$rugpjutis_days = 30;
$rugsejis_days = 30;
$spalis_days = 31;
$x = $liepa_days + $rugpjutis_days + $rugsejis_days + $spalis_days + date('d');
?>
<html>
    <head>
        <title>

        </title>
    </head>
    <body>
        <p>
            <?php print "Nuo Liepos iki šiandien praėjo " . $x . " dienų" ?>
        </p>
    </body>
</html>