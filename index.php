<!DOCTYPE html>
<html>
    <head> 
        <style>
            .kauliukas {
                width: 400px;
                height: 400px;
                background-size: cover;
            }
            .class-1 {
                background-image: url("http://clipart-library.com/images/kcKoqXL6i.gif");
            }
                .class-2 {
                    background-image: url("http://clipart-library.com/images/kcM8na5cj.png");
                }
                .class-3 {
                    background-image: url("http://clipart-library.com/images/LidRo7Ei4.jpg");
                }
                .class-4 {
                    background-image: url("http://clipart-library.com/images/pi5goLBi9.png");
                }
                .class-5 {
                    background-image: url("https://upload.wikimedia.org/wikipedia/commons/d/dc/Dice-5.svg");
                }
                .class-6 {
                    background-image: url("https://upload.wikimedia.org/wikipedia/commons/1/14/Dice-6.svg");
                }
            </style>
        </head>
        <body>
            <div class="kauliukas class-<?php print rand(1, 6) ?>"></div>
        </body>
    </html>
