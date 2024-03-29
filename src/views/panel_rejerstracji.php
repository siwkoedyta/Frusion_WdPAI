<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frusion - create account</title>
    <link rel="stylesheet" href="/public/css/panel_rejertracji.css">
    <link rel="stylesheet" href="/public/css/panel_logowania.css">
</head>
<body class="registration">
    <svg class="fala" xmlns="http://www.w3.org/2000/svg" width="1728" height="244" viewBox="0 0 1728 244" fill="none">
      <path d="M499 149C339 340.2 44.3333 197 -83 101.5V-190C56 -199 338.2 -217 355 -217H1606C1620 -217 1808.17 -181 1900.5 -163C1900.5 -121.833 1873.9 -8.39999 1767.5 116C1634.5 271.5 1285.5 220.5 1181 165C1076.5 109.5 699 -90 499 149Z" fill="url(#paint0_linear_10_2444)"/>
      <defs>
        <linearGradient id="paint0_linear_10_2444" x1="908.75" y1="-217" x2="908.75" y2="243.309" gradientUnits="userSpaceOnUse">
          <stop stop-color="#351431"/>
          <stop offset="1" stop-color="#775253"/>
        </linearGradient>
      </defs>
    </svg>

    <div class="registration-container">
        <h1 id="create_account">Create account</h1>
        <form class="panel_rejerstracji" action="panel_rejerstracji" method="POST" id="registration_form">

          <input name="email" id="email" type="email" placeholder="Email">
          <input name="password" id="password" type="password" placeholder="Password">
            <input name="repeat_password" id="repeat_passowrd" type="password" placeholder="Repeat password">
            <input name="mobile" id="mobile" type="tel" placeholder="Phone" required>
          <input name="frusion_name" id="frusion_name" type="text" placeholder="Frusion name">

            <div class="error-message" id="message">
                <?php
                if (isset($messages)){
                    foreach ($messages as $message){
                        echo $message;
                    }
                }
                ?>
            </div>
            <p id="emailFormatMessage" class="error-message"></p>
            <p id="passwordFormatMessage" class="error-message"></p>
            <p id="passwordMismatchMessage" class="error-message"></p>
            <p id="phoneNumberErrorMessage" class="error-message"></p>
            <p id="frusionNameErrorMessage" class="error-message"></p>



          <div class="dolne_przyciski">

              <div class="Sign_in_z_strzalka">
                  <button class="strzalka_lewa" id="przycisk_sign_in">
                    <svg xmlns="http://www.w3.org/2000/svg" width="71" height="43" viewBox="0 0 71 43" fill="none">
                      <rect width="71" height="43" rx="17" transform="matrix(-1 0 0 1 71 0)" fill="url(#paint0_linear_10_1510)"/>
                      <path d="M46.9108 21.5C46.9108 22.2858 46.2738 22.9228 45.488 22.9228H29.5522L36.5067 29.8599C37.065 30.4169 37.065 31.3213 36.5067 31.8782C35.9503 32.4332 35.0498 32.4332 34.4934 31.8782L24.5671 21.9765C24.3034 21.7135 24.3034 21.2864 24.5671 21.0234L34.4934 11.1217C35.0498 10.5668 35.9503 10.5668 36.5067 11.1217C37.065 11.6787 37.065 12.5831 36.5067 13.14L29.5522 20.0772H45.488C46.2738 20.0772 46.9108 20.7142 46.9108 21.5Z" fill="#E9E9E9"/>
                      <defs>
                        <linearGradient id="paint0_linear_10_1510" x1="0" y1="0" x2="38.1071" y2="62.921" gradientUnits="userSpaceOnUse">
                          <stop stop-color="#775253"/>
                          <stop offset="1" stop-color="#351431"/>
                        </linearGradient>
                      </defs>
                    </svg>
                  </button>
                  <h2 id="Sign-in">Sign in</h2>
              </div>
  
              <div class="Create_z_strzalka">
                <h2 id="Create">Create</h2>
                <button class="strzalka_prawa" id="przycisk_create" type="submit">
                  <svg xmlns="http://www.w3.org/2000/svg" width="71" height="43" viewBox="0 0 71 43" fill="none">
                    <rect width="71" height="43" rx="17" fill="url(#paint0_linear_10_1425)"/>
                    <path d="M24.0892 21.5C24.0892 22.2858 24.7262 22.9228 25.512 22.9228H41.4478L34.4933 29.8599C33.935 30.4169 33.935 31.3213 34.4933 31.8782C35.0497 32.4332 35.9502 32.4332 36.5066 31.8782L46.4329 21.9765C46.6966 21.7135 46.6966 21.2864 46.4329 21.0234L36.5066 11.1217C35.9502 10.5668 35.0497 10.5668 34.4933 11.1217C33.935 11.6787 33.935 12.5831 34.4933 13.14L41.4478 20.0772H25.512C24.7262 20.0772 24.0892 20.7142 24.0892 21.5Z" fill="#E9E9E9"/>
                    <defs>
                      <linearGradient id="paint0_linear_10_1425" x1="0" y1="0" x2="38.1071" y2="62.921" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#775253"/>
                        <stop offset="1" stop-color="#351431"/>
                      </linearGradient>
                    </defs>
                  </svg>
                </button>
              </div>
              
          </div>

        </form>
    </div>

    <script defer src="/public/js/przycisk_strona_logowania_sign_in.js"></script>
    <script defer src="/public/js/rejerstracja.js"></script>


</body>
</html>