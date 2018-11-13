<?php
/**
 * 
 */
$choices = [
    '100%' => 'Visiškai taip!',
    '70%' => 'Turbūt taip',
    '50%' => 'Neaišku',
    '30%' => 'Turbūt ne',
    '0%' => 'Tikrai ne!'
];

function magic_ball($choices) {
    return $choices[array_rand($choices)];
}
?>
<html>
    <head>
        <style>

        </style>
    </head>
    <body>
        <h1><?php print magic_ball($choices) ?></h1>
    </body>
</html>