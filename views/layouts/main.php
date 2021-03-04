<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pineapple</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="script.js"></script>
        <link rel="icon" href="img/union.svg">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <nav>
            <ul>
                <li class="left-side">
                    <a href="#">
                        <img id="union" src="img/union.svg" alt="Pineaple">
                        <img id="pineapple" src="img/pineapple.svg" alt="pineapple">
                    </a>
                </li>
                <li class="right-side">
                    <a href="#">About</a>
                    <a href="#">How it works</a> 
                    <a href="#">Contact</a>
                </li>
            </ul>
        </nav>
        <div class="box">
            {{content}}
            <span class="line"></span>
            <div class="social-icons">
                <a href="#" id="fb">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" id="ig">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" id="tt">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" id="yt">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>
        <div class="background"></div>
    </body>
</html>