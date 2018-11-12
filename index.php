<?php
$fridge = ['Kebabas' => '2.50', 'Alus' => '1.89', 'Burokai' => '1.50'];
$indeksai = array_keys($fridge);
$produkto_indekso_indeksas = rand(0, count($indeksai) - 1);
$produkto_indeksas = $indeksai[$produkto_indekso_indeksas];
?>
<html>
    <head>
        <style>
            div {
                width: 100px;
                height: 100px;
                background-size: cover;
            }
            .Kebabas {
                background-image: url(http://www.snackcity.lt/UserFiles/image/kebabai/liux-kebabas1.png);
            }
            .Alus {
                background-image: url(https://www.barbora.lt/api/Images/GetInventoryImage?id=745450b8-147c-46e9-9870-90af17d7d5e6);
            }
            .Burokai {
                background-image: url(http://lsveikata.lt/upload/articles_images/5679/def/burokai.jpg);
            }

        </style>
    </head>
    <body>
        <h2>Kazkada pirkai:</h2> 
        <?php foreach ($fridge as $key => $produkto_kaina): ?>
            <div class="<?php print $key ?>"><?php print $produkto_kaina ?></div>
        <?php endforeach; ?>
    </body>
</html>