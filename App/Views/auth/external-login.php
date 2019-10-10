<?php
use App\Helpers\UtilsHelper;
use App\Helpers\FlashMessage;
?>

<div class="login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="login">
                    <div class="login__logo">
                        <img src="<?= UtilsHelper::base_url("/img/logo.png")?>" alt="Logo SACC">
                    </div>
                    <h2 class="login__title">Visitante - Login</h2>
                    <form class="login__form" method="post">
                        <?php if (FlashMessage::hasMessage('loginError')): ?>
                        <div class="alert alert--error"><?= FlashMessage::getMessage('loginError') ?></div>
                        <?php endif; ?>
                        <div class="form__content">
                            <input type="email" required class="form__input" name="user" placeholder="E-mail">
                        </div>
                        <div class="form__content">
                            <input type="password" required class="form__input" name="password" placeholder="Senha">
                        </div>
                        <button type="submit" class="btn btn--primary btn--fluid">Login</button>
                    </form>
                    <div class="text-center">
                        <hr>
                        <span>Não tem conta?</span>
                    </div>
                    <a href="<?= UtilsHelper::base_url("/inscricao/visitante/cadastro")?>" class="btn btn--secondary btn--fluid">Registrar</a>
                    <div class="form__resources">
                        <a class="resources__anchor" href="<?= UtilsHelper::base_url("/inscricao/aluno")?>">
                            Estudante UFFS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
