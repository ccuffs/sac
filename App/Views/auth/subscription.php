<?php
use App\Helpers\UtilsHelper;
?>

<div class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="login">
                    <div class="login__logo">
                        <img src="<?= UtilsHelper::base_url("/img/logo.png")?>" alt="Logo SACC">
                    </div>
                    <div class="ticket-wrapper">
                        <div class="ticket-wrapper__title" scroll-sensitive="animate-left-right">
                            <h2 class="about__title">Você é:</h2>
                        </div>
                        <div class="ticket-wrapper__buttons "scroll-sensitive="animate-right-left-3">
                        <a href="<?= UtilsHelper::base_url("/inscricao/aluno") ?>" class="btn btn--secondary">Estudante UFFS</a>
                        <br>
                        <a href="<?= UtilsHelper::base_url("/inscricao/visitante/cadastro") ?>" class="btn btn--primary">Visitante</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
