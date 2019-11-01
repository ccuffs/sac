<?php
use App\Helpers\UtilsHelper;
use App\Helpers\AuthHelper;

$_user = AuthHelper::getAuthenticatedUser();
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
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/table.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/helpers.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/index.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/card.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/buttons.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/animations.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/layout.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/form.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/alert.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/home.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/login.css") ?>">
  <link rel="stylesheet" href="<?= UtilsHelper::base_url("/css/website/profile.css") ?>">
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
              <a href="<?= UtilsHelper::base_url("") ?>">
                <img src="<?= UtilsHelper::base_url("/img/logo.png") ?>">
              </a>
            </figure>
          </div>
          <div class="col-md-10 d-none d-md-block">
            <nav class="navbar__menu">
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#sobre")?>">Sobre</a>
              <!-- <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#palestrantes")?>">Palestrantes</a> -->
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#schedule")?>">Programação</a>
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#valores")?>">Valores</a>
              <?php if ($_user): ?>
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("/perfil")?>">Perfil</a>
              <?php else: ?>
              <a class="navbar__archor" href="<?= UtilsHelper::base_url("/inscricao")?>">Inscrições</a>
              <?php endif; ?>
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
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#about")?>">Sobre</a>
        <!-- <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#speakers")?>">Palestrantes</a> -->
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#programming")?>">Programação</a>
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("/#values")?>">Valores</a>
        <?php if ($_user): ?>
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("/perfil")?>">Perfil</a>
        <?php else: ?>
        <a class="navbar__archor" href="<?= UtilsHelper::base_url("/inscricao")?>">Inscrições</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>