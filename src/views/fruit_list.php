<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frusion - fruit list</title>
    
    <link rel="stylesheet" href="/public/css/fruit_list.css">
    <link rel="stylesheet" href="/public/css/kontent.css">
    <link rel="stylesheet" href="/public/css/prawa_kolumna.css">
    <link rel="stylesheet" href="/public/css/lewa_kolumna.css">
    <link rel="stylesheet" href="/public/css/podstawa.css">
    <link rel="stylesheet" href="/public/css/sidebar.css">
    <link rel="stylesheet" href="/public/css/okno_modalne_kup_owoc.css">
    <link rel="stylesheet" href="/public/css/add_client.css">
    <link rel="stylesheet" href="/public/css/boxes.css">



</head>
<body class="panel_glowny">

    <div class="kontener">
        <div id="overlay"></div>
        <div class="pasek_boczny" id="mySidebar">
            <button id="closeSidebar">&times;</button>
            <div class="logo_z_napisem">
                <svg class="logo" xmlns="http://www.w3.org/2000/svg" width="61" height="57" viewBox="0 0 81 77" fill="none">
                    <g clip-path="url(#clip0_52_816)">
                      <path d="M61.9046 11.0315C61.9046 11.0315 46.2085 -3.80612 30.611 3.56291C15.0135 10.9319 11.3609 23.9771 8.59682 37.4206C5.83271 50.8641 7.21477 47.2792 4.1545 57.2373C1.09424 67.1955 4.45066 75.6599 16.9879 76.9545C29.5251 78.249 45.4187 72.6725 57.4623 59.0298C69.5059 45.3871 78.4893 25.7696 61.9046 11.0315Z" fill="#775253"/>
                      <path d="M38.7821 1.50525C36.1127 1.62696 33.3605 2.23364 30.6106 3.5328C15.0132 10.9018 11.3606 23.947 8.59646 37.3905C5.83236 50.834 7.21425 47.249 4.15399 57.2072C1.34056 66.3621 3.95696 74.2499 14.1379 76.4694C12.0639 70.9583 15.1615 62.3214 16.4261 57.7289C17.8222 52.6591 17.473 51.2507 18.2409 43.2938C19.0087 35.3369 19.9861 21.3948 26.7571 11.4663C30.8551 5.45735 35.6402 2.72685 38.7821 1.50525Z" fill="#351431"/>
                      <path d="M64.4298 13.5256C64.6431 15.8439 66.2253 20.6319 63.2939 28.8942C60.2565 37.4551 54.5351 50.363 57.2395 59.2793C57.4726 59.0243 57.7089 58.7686 57.9393 58.5076C61.4199 54.5649 64.8163 50.7518 67.2424 46.073C68.5308 41.1949 70.3239 34.2847 71.5977 28.8363C71.3301 23.371 69.0987 18.4344 64.4298 13.5256Z" fill="#351431"/>
                      <path d="M66.2481 5.30459C66.4456 5.55354 75.8238 15.5615 76.5642 26.1669C77.3045 36.7723 74.5404 41.9008 72.7635 45.9836C70.9866 50.0665 62.8423 62.6137 60.4237 62.1656C58.0051 61.7175 58.4 46.0334 62.6449 35.3782C66.8898 24.723 68.6174 10.7816 65.6558 6.64894C62.6943 2.51631 66.2481 5.30459 66.2481 5.30459Z" fill="#BDC696"/>
                      <path d="M65.8534 5.35773C65.8534 5.35773 65.7671 6.07008 65.6902 6.70321C68.603 10.8968 66.8729 24.7686 62.6448 35.3815C58.4 46.0367 58.0052 61.7208 60.4238 62.1689C60.4732 62.1781 60.5257 62.1799 60.5798 62.1784C61.4712 60.1048 64.2065 53.6181 66.7909 46.0867C69.9005 37.0248 70.493 28.7095 70.7398 20.1455C70.9866 11.5815 65.8534 5.35773 65.8534 5.35773Z" fill="#9CAA63"/>
                      <path d="M60.722 10.0133C60.722 10.0133 63.4537 6.42078 64.6229 3.11129C65.7921 -0.198201 66.5774 0.312303 67.0486 0.435529C67.5198 0.558754 68.5668 0.981251 67.6943 3.39296C66.8217 5.80465 65.2194 10.1258 62.8111 11.8686C62.8111 11.8686 61.5343 10.6948 60.722 10.0133Z" fill="#8C5C40"/>
                      <path d="M66.5748 0.343443C66.1052 0.337745 65.4633 0.742718 64.6229 3.12141C64.5772 3.25071 64.5276 3.38145 64.4753 3.51298C64.8217 4.19791 65.5996 5.17337 67.1323 4.78124C67.3638 4.25789 67.555 3.78811 67.6943 3.40306C68.5668 0.99136 67.5198 0.569066 67.0486 0.44584C66.9161 0.411214 66.7586 0.345766 66.5748 0.343443Z" fill="#9F6C4E" fill-opacity="0.991643"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_52_816">
                        <rect width="81" height="77" fill="white"/>
                      </clipPath>
                    </defs>
                  </svg>
                <h1 id="Frusion">Frusion</h1>
            </div>
    
            <ul class="menu">
                <li id="home"><a href="panel_glowny">Home</a></li>
                <li id="status_frusion"><a href="status_frusion">Status Frusion</a></li>
                <li id="fruit_list" class="active"><a href="fruit_list">Fruits</a></li>
                <li id="boxes_li"><a href="boxes">Boxes</a></li>
                <li id="add_client"><a href="add_client">Clients</a></li>
                <li id="log_out">
                    <form id="logoutForm" action="wyloguj" method="POST">
                        <button type="submit">Log out</button>
                    </form>
                </li>
            </ul>

        </div>



        <div class="kontent">
            <svg class="falka" xmlns="http://www.w3.org/2000/svg" width="375" height="51" viewBox="0 0 375 51" fill="none">
                <path d="M296.687 50.9743C355.778 50.2439 370.577 30.0458 429.667 29.307C435.259 29.2371 444 29.307 444 29.307V0H-82.9518C-82.9518 0 -134.392 15.0993 -92.6965 22.8783C-16.7141 37.054 50.9193 15.1162 136.634 22.8783C206.002 29.1601 224.269 51.8693 296.687 50.9743Z" fill="url(#paint0_linear_3_1452)"/>
                <defs>
                  <linearGradient id="paint0_linear_3_1452" x1="134.245" y1="-5.45581" x2="134.245" y2="51" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#775253"/>
                    <stop offset="1" stop-color="#351431"/>
                  </linearGradient>
                </defs>
              </svg>

            <div class="naglowek_hamburger">
                <div id="hamburgerL">
                    <svg  class="hamburger_svg" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.2C0 0.537258 0.537258 0 1.2 0H22.8C23.4627 0 24 0.537258 24 1.2C24 1.86274 23.4627 2.4 22.8 2.4H1.2C0.537258 2.4 0 1.86274 0 1.2ZM0 9.59992C0 8.93718 0.537259 8.39992 1.2 8.39992H16.8C17.4627 8.39992 18 8.93718 18 9.59992C18 10.2627 17.4627 10.7999 16.8 10.7999H1.2C0.537259 10.7999 0 10.2627 0 9.59992ZM1.2 16.8C0.537258 16.8 0 17.3373 0 18C0 18.6628 0.537258 19.2 1.2 19.2H22.8C23.4627 19.2 24 18.6628 24 18C24 17.3373 23.4627 16.8 22.8 16.8H1.2Z" fill="#351431"/>
                      </svg>
                </div>
                <h1 id="naglowek">Fruits</h1>
                <div id="hamburgerP">
                    <svg class="hamburger_svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.2C0 0.537258 0.537258 0 1.2 0H22.8C23.4627 0 24 0.537258 24 1.2C24 1.86274 23.4627 2.4 22.8 2.4H1.2C0.537258 2.4 0 1.86274 0 1.2ZM0 9.59992C0 8.93718 0.537259 8.39992 1.2 8.39992H16.8C17.4627 8.39992 18 8.93718 18 9.59992C18 10.2627 17.4627 10.7999 16.8 10.7999H1.2C0.537259 10.7999 0 10.2627 0 9.59992ZM1.2 16.8C0.537258 16.8 0 17.3373 0 18C0 18.6628 0.537258 19.2 1.2 19.2H22.8C23.4627 19.2 24 18.6628 24 18C24 17.3373 23.4627 16.8 22.8 16.8H1.2Z" fill="#351431"/>
                      </svg>
                </div>
            </div>

            <div class="zawartosc_strony_kolumny">

                <div class="pierwsza_kolumna">
                    <div class="prostokat_zielony"><h2 id="naglowek_modala">Fruit list</h2></div>
                    <?php foreach($fruits as $fruit): ?>
                        <div class="prostokat_bialy">
                            <div id="rodzaj_skrzynki"><?= $fruit->getTypeFruit(); ?></div>
                            <div class="waga_skrzynki_cala">
                                <div id="waga_skrzynki"><?= $fruit->getPriceFruit(); ?></div>
                                <div id="złotówki">zł</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
    
                <div class="druga_kolumna">

                    <div class="prostokat">
                        <h2 id="naglowek_modala">Set the price</h2>
                        <form class="set_the_price" action="fruit_list" method="post">
                            <input name="type" value="setPrice" type="hidden">
                            <select name="typeFruitSet">
                                <option value="" disabled selected>Name of the fruit</option>
                                <?php
                                $fruitRepository = new FruitRepository();
                                $fruitNames = $fruitRepository->getAllFruitNames();
                                foreach ($fruitNames as $fruitName) {
                                    echo '<option value="' . $fruitName . '">' . $fruitName . '</option>';
                                }
                                ?>
                            </select>
                            <input id="price" name ="newPrice" type="number" placeholder="Price">

                            <div id="message">
                                <?php if (isset($setPriceMsg)) echo $setPriceMsg; ?>
                            </div>

                            <div class="przyciski">
                                <button type="submit" class="przycisk_add" id="setFruitPriceButton">Change</button>
                            </div>
                        </form>

                    </div>
        
                    <div class="prostokat">
                        <h2 id="naglowek_modala">Add fruit</h2>
                        <form class="addFruitForm" action="fruit_list" method="post">
                            <input name="type" value="addFruit" type="hidden">
                            <input name="typeFruit" type="text" placeholder="Name of the fruit">

                            <div id="message">
                                <?php if (isset($addFruitMsg)) echo $addFruitMsg; ?>
                            </div>

                            <div class="przyciski">
                                <button type="submit" class="przycisk_add">Add</button>
                            </div>
                        </form>
                    </div>


                    <div class="prostokat">
                        <h2 id="naglowek_modala">Remove fruit</h2>
                        <form class="remove_fruit" id="removeFruitForm" action="fruit_list" method="post">
                            <input name="type" value="removeFruit" type="hidden">
                            <select name="typeFruit">
                                <option value="" disabled selected>Name of the fruit</option>
                                <?php
                                    $fruitRepository = new FruitRepository();
                                    $fruitNames = $fruitRepository->getAllFruitNames();
                                    foreach ($fruitNames as $fruitName) {
                                        echo '<option value="' . $fruitName . '">' . $fruitName . '</option>';
                                    }
                                ?>
                            </select>

                            <div id="message">
                                <?php if (isset($removeFruitMsg)) echo $removeFruitMsg; ?>
                            </div>

                            <div class="przyciski">
                                <button type="submit" class="przycisk_remove">Remove</button>
                            </div>
                        </form>


                    </div>

                    
                </div>
    
            </div>

        </div>
        
    </div>

    <script src="/public/js/sidebar.js"></script>
    <script src="/public/js/otworz_panel_boczny.js"></script>
    <script src="/public/js/zamknij_panel_boczny.js"></script>
<!--    <script defer src="/public/js/add_fruit.js"></script>-->
<!--    <script defer src="/public/js/remove_fruit.js"></script>-->

</body>
</html>