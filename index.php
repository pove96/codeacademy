<?php
date_default_timezone_set('Europe/Vilnius');
$bokalas = 'bokalas';
$tulikas = 'tulikas';
$beer_price = 3.49;
$time_per_beer = 60;
?>
<html
    <head>
        <style>
            .tulikas{
                background-image: url(http://www.stickpng.com/assets/images/589396308370b70e212f3e6a.png);
                height: 100px;
                width: 100px;
                background-size: cover;
            }
            .bokalas {
                background-image: url(https://mbtskoudsalg.com/images/alcohol-png-transparent-3.png);
                height: 400px;
                width: 200px;
                background-size: cover;
                background-size: contain;
                background-repeat: no-repeat;
                margin: 0 auto;
            }
            .numeriopozicija {
                position: absolute;
                top: 0;
                right: 0;
                background: black;
                color: white;
            }
        </style>
    </head>
    <body>
        <?php for ($i = 1; $i <= 7; $i++): ?>
            <div style="position: relative; background-color:rgba(0, 0, 0, 0.<?php print $i ?>)">
                <span class="numeriopozicija" style="text-align:right;">
                    <?php print "Bokalo numeris " . $i . ", Iš viso išleidau " . ($i * $beer_price) . "€" ?>
                </span>
                <span class="numeriopizicija" style="text-align: left;">
                    <?php print date('G, i', strtotime("+$i hours")); ?>
                </span>
                <div class="bokalas" style="filter: blur(<?php print $i ?>px)"></div>
            </div>
            <?php if ($i % 2 == 0): ?>
                <div class="tulikas"></div>
            <?php endif; ?>
        <?php endfor; ?>
    </body>
</html>