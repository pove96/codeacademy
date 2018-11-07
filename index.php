<?php
date_default_timezone_set('Europe/Vilnius');

if (date('s') % 2 == 0) {
    $a = 'kvadratas';
} else {
    $a = 'apskritimas';
}
?>
<html>
    <head>
        <style>
            .kvadratas {
                background-image: url(https://upload.wikimedia.org/wikipedia/commons/d/dd/Square_-_black_simple.svg);
            }
            .apskritimas {
                background-image: url(https://upload.wikimedia.org/wikipedia/commons/a/a0/Circle_-_black_simple.svg);
            }
            .klase {
                height:100px;
                width:100px;
                background-size: cover;
            }
        </style>
        <title>

        </title>
    </head>
    <body>
        <div class="klase <?php print $a; ?>"><?php print date('s') ?></div>

    </body>
</html>