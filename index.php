<?php
date_default_timezone_set('Europe/Vilnius');
?>
<html>
    <body>
        <title>
            PHP lydės ir <?php print date('Y', strtotime('+' . rand(0, 10) . 'years')); ?>
        </title>
        <h1>
            <b>Povilas</b> - Galbūt turėsiu <?php print rand(1, 5); ?> vaikų!
        </h1>
        <p>
            D. Trump'as nebebus prezidentu <?php print rand(2021, 2031) . ' ' . date('m d') ?>
        </p>
    </body>
</html>