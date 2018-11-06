<!DOCTYPE html>
<html>
    <head> 
        <style>
            .class-1 {
                color: red;
                font-size: 100%;
            }
            .class-2 {
                color: blue;
                font-size: 100%;
            }
            .class-3 {
                color: green;
                font-size: 100%;
            }
        </style>
    <body>
        <p class="class-<?php print rand(1, 3) ?>"> Vienas </p>
        <p class="class-<?php print rand(1, 3) ?>"> Du </p>
        <p class="class-<?php print rand(1, 3) ?>"> Trys </p>
        
    </body>
</head>
</html>
