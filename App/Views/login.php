<?php
use App\Helpers\UtilsHelper;
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" href="<?= UtilsHelper::base_url("/img/favicon.ico") ?>" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/vendor/bootstrap/css/bootstrap-reboot.min.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/vendor/bootstrap/css/bootstrap-grid.min.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/vendor/bootstrap/css/bootstrap-utilities.min.css") ?>">
  <!--FontAwesome-->
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/vendor/fontawesome/css/all.min.css") ?>">
  <!-- index CSS -->
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/fonts.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/index.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/card.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/form.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/buttons.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/login.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/navbar.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/section.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/animations.css") ?>">
  <link href="https://fonts.googleapis.com/css?family=Trebuchet+MS:400,600,700&display=swap" rel="stylesheet">

  <title>SACC | UFFS</title>
</head>

<body>

  <header>
    <div class="navbar">
      <div class="container">
        <div class="row align-items-center">
          <div class="col col-md-2">
            <figure class="navbar__logo">
              <a href="<?= UtilsHelper::base_url("/") ?>">
                <img src="<?= UtilsHelper::base_url("/img/logo.png") ?>">
              </a>
            </figure>
          </div>
          <div class="col-md-10 d-none d-md-block">
            <nav class="navbar__menu">
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("#about")?>">Sobre</a>
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("#speakers")?>">Palestrantes</a>
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("#programming")?>">Programação</a>
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("/login")?>">Inscrições</a>
            </nav>
          </div>
          <div class="col text-right d-block d-md-none">
            <button class="navbar__toggle-button">
              <i class="fa fa-bars"></i>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="menu-mobile">
      <nav id="menu" class="menu-mobile__content">
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("#about")?>">Sobre</a>
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("#speakers")?>">Palestrantes</a>
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("#programming")?>">Programação</a>
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("/login")?>">Inscrições</a>
      </nav>
    </div>
  </header>
    

    <div class="main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="login ">
                        <div class="login__logo">
                            <img src="<?= UtilsHelper::base_url("/img/logo.png")?>" alt="Logo SACC">
                        </div>
                        <h2 class="login__title">Entre com seu idUFFS</h2>
                        <div class="login__form">
                            <form class="form" method="post">
                                <div class="form__content">
                                    <input type="text" class="form__input" name="user" id="idName"
                                        placeholder="IdUFFS">
                                </div>
                                <div class="form__content">
                                    <input type="password" class="form__input" name="password" id="idPass"
                                        placeholder="Senha">
                                </div>
                                <div class="form__check">
                                    <input type="checkbox" class="form__check" name="txtCheck" id="idCheck">
                                    <label for="idCheck">Lembrar meu usuário</label>
                                </div>
                                <div class="form__btn">
                                    <button type="submit" class="btn btn--primary btn--fluid" name="txtBtn" id="idBtn">entrar</button>
                                </div>

                            </form>
                            <div class="form__resources">
                                <a class="resources__anchor"href="https://id.uffs.edu.br/id/XUI/?realm=/#forgotUsername/" target="_blanck">
                                    Não sabe seu idUFFS?
                                </a>
                                <a class="resources__anchor" href="https://id.uffs.edu.br/id/XUI/?realm=/#passwordReset/ " target="_blanck">
                                    Esqueceu a Senha?
                                </a>
                                <a class="resources__anchor" href="https://ati.uffs.edu.br/public.pl?CategoryID=17" target="_blanck">
                                    Ajuda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= UtilsHelper::base_url("/js/website/index.js") ?>"></script>
</body>

</html>
