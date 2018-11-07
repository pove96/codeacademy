<?php
$mano_pinigai = 1000;
$spent_per_month = 600;
$earned_per_month = 800;
$unknown_per_month = rand(20, 80);
$months = 24;
$wallet_forecast = $mano_pinigai + ($earned_per_month - $spent_per_month - $unknown_per_month) * $months;
$data = date('D, d M Y', strtotime("+$months months"));
?>
<html>
    <head>
        <title>

        </title>
    </head>
    <body>
        <p>
            <?php print "Po" . $months . $data . " tikėtina turėsiu" . $wallet_forecast ?>
        </p>
    </body>
</html>