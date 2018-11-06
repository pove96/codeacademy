<?php
date_default_timezone_set('Europe/Vilnius');
?>
<html>
    <body>
        <title>
            PHP lydės ir <?php print 'ryt ' . date('d-M-Y', strtotime('+1 day')) ?>
        </title>
        <h1><b>Povilas</b> - PHP su manim buvo ir <?php print date('G', strtotime('-1 hour')) . ' valandą' ?> </h1> 
        <p>
            <?php print 'sekantys metai ' . date('Y', strtotime('+1 year')) ?> ne už kalnų!
        </p>
    </body>
</html>