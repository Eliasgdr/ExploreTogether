<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Together</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js?<?php echo time(); ?>"></script>
    <link href="./stylessheet/profile.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <div class="title">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" onclick="redirectMessages()">Messages</a>
            <a type="button" class="titleButton" onclick="window.location.href='welcome.php'">welcome</a>
        </div>
    </header>
    <div class="content">
        <div class="card">
            <div class="cardPicture"></div>
            <div class="cardInfo">
                <div class="nameInfo">
                    <h3 id="name">DAS Shawrov</h3>
                    <h3 id="userName">Shaw</h3>
                </div>
                <hr>

                <div class="subscription">
                    <h3>Exposant</h3>
                    <a type="button" class="subscriptionButton" onclick="window.location.href='subscription.php'">upgrade</a>
                </div>

                <hr>
                <div class="userInfo">
                    <h5 id="userBirth">Birthay : unknow</h5>
                    <div class="mainCountry">
                        <h4 id="country">Bangladesh</h4>
                    </div>
                    <h5 id="userEmail">E-mail : bo.antonin@gmail.com</h5>
                    <div class="userDescript">
                        <h5>Description : </h5>
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Amet praesentium similique qui nihil quasi atque! Adipisci distinctio ratione quo nesciunt quibusdam doloribus corporis. Consectetur earum similique dolorum sapiente. Dolorem facere molestias ullam ducimus non voluptatem fugiat? Nobis consequatur explicabo dolorem! Autem consequuntur adipisci, natus quas aliquid illo magnam. Sapiente reiciendis nobis quaerat mollitia impedit, cumque aspernatur nisi magni dolores dolore labore amet commodi voluptatibus doloribus sequi et incidunt, veritatis nulla! Ab hic quis odit neque enim, ipsum qui earum dicta nostrum, omnis mollitia, libero vel voluptatem sint nam facere maiores odio obcaecati nulla dolor. Aperiam enim, cum dolorem qui illo minima. Harum, commodi? Accusamus optio quaerat expedita fugiat reiciendis voluptatibus possimus, iure dolores hic, nihil eaque nulla quo fugit minima illum. Maxime commodi nobis, aspernatur consequatur vel in. Qui eum perspiciatis, facilis perferendis optio nisi aliquid accusantium eos quasi, atque alias repellat, quisquam fuga deleniti vero. Maiores voluptatum amet ea!
                        </p>
                    </div>
                    
                </div>
            </div>
            <div class="userMap"></div>
        </div>
    </div>
    <footer>
        <h5>&copy; 2024 Travel Together | All Rights Reserved<br></h5>
    </footer>
</body>