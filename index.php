<!DOCTYPE html>
<?php
date_default_timezone_set('Europe/Vilnius');
?>
<html>
    <head> 
        <style>
            .bomba {
                width: 100px;
                height: 100px;
                transform: scale(0.<?php print date('s') ?>);
                background-image: url(https://files.gamebanana.com/img/ico/sprays/4ea33068c0dcc.png);
                background-size: contain;
                background-repeat: no-repeat;
            }
            .sprogsta00 {
                width: 400px;
                height: 400px;
                content: url(https://upload.wikimedia.org/wikipedia/commons/thumb/7/79/Operation_Upshot-Knothole_-_Badger_001.jpg/1024px-Operation_Upshot-Knothole_-_Badger_001.jpg);
                <?php print date('s') ?>
                transform: scale(1);
            }


        </style>
    </head>
    <body>
        <div class="sprogsta<?php print date('s') ?> bomba">
        </div>
        <p><?php print date('s'); ?></p>

    </body>
</html>
